<?php

namespace Ufo\Session;


use Ufo\Log\Trace as Trace;
use Ufo\Error\Stack as ErrorStack;
use Ufo\Security\Check as Check;


/**
 * Classe singleton de gestion de la session
 * 
 * @author gb-michel
 * @version 1.1 Transformation en singleton
 */
class Session
{
	/**
	 * @access private 
	 * @staticvar Session Instance unique de la classe
	 */
	private static $_instance = null;
	private static $_stateRestore = false;
	private static $_isOpen = false;
	private static $_tokenChecked = false;
	
	
	/**
	 * @access private
	 * @var String Nom de la session
	 */	
	private $_sessname = null;
	private $_profile = null;
	private $_data ;
	
	/**
	 * @access private
	 * @var String Valeur du token
	 */
	private $_token = null ;
	
	
	/**
	 * @access private
	 * @var String Nom du token
	 */
	private $_tokenname = false;
	
	
	
	
	
	/**
	 * Teste si la valeur du token et celle enregistre dans la session
	 * sont identique. Si les valeurs sont differentes, la session
	 * est detruite.
	 * @access private
	 * @method boolean Verifie la concordance entre la session et le token
	 * @return boolean TRUE si la session et token vont ensemble, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	private static function checkToken( $replace_token = true)
	{
		if( !isset($_SESSION['ss_tokenname']) 
			|| !isset($_SESSION['ss_token']) ){
			return false;
		}
		
		// verifie que le token existe
		if( !isset($_COOKIE[$_SESSION['ss_tokenname']])){
			return false;
		}

		
		// verifie le format du token
		if( Check::hexadecimalText( $_COOKIE[$_SESSION['ss_tokenname']], 40) == false ){
			return false ;
		}
	
		
		/* Comparaison de valeurs hachees pour se premunir des
			octets null qui aurait pu etre introduit dans le
		de cookie de session */
		if( sha1($_SESSION['ss_token']) !== sha1($_COOKIE[$_SESSION['ss_tokenname']]) ){
			return false ;
		}

		
		// maj du cookie token
		if( (self::$_tokenChecked === false) && ($replace_token === true)){
			
			if( self::$_instance->_profile->get('TOKEN_REGEN') === true){

				// suppression de l'ancien token
				setcookie( $_SESSION['ss_tokenname'], '', time()-3600, self::$_instance->_profile->get('SESSION_PATH'));
				
				// creation du nouveau token
				self::$_instance->createToken();
				self::$_tokenChecked = true;
			}		
		}
		
		return true ;
	}
	
	
	
	/**
	 * @access private
	 * @method void Cree ou modifie le token
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	private function createToken()
	{	
		// Creation des donnees du token
		if( $this->_profile->get('USE_DOUBLE_TOKEN') == true ){			
			$this->_tokenname = md5(rand(20,100).time());
		}
		else{
			$this->_tokenname = $this->_profile->get('TOKEN_NAME') ;
		}		
		$this->_token = sha1(time().rand(0,100).$this->_profile->get('TOKEN_GDS')) ;
		
		if( self::$_isOpen===true){
			$_SESSION['ss_token'] = $this->_token ;
			$_SESSION['ss_tokenname'] = $this->_tokenname ;	
		}
			
		// Envoie du token
		setcookie( $this->_tokenname, $this->_token, 
		  time()+intval($this->_profile->get('SESSION_EXPIRE')), 
		  $this->_profile->get('SESSION_PATH')
        );
	}
	
	/**
	 * Cree une nouvelle session et son token, le nom de la session
	 * sera celui utilise lors de la construction de l'objet
	 *
	 * Cree une session utilisateur et met en place un token aleatoire,
	 * en utilisant l'ID et le login de l'utilisateur. Plusieurs parametres
	 * sont configurable dans le fichier de config, tels que :
	 * - Nom par defaut de la session
	 * - Nom par default du token
	 * - Duree de la session
	 * - Repertoire autorise
	 * - GDS de la valeur du token
	 * - Mecanisme "Double token", dans ce cas le nom du token est aussi aleatoire.
	 *
	 * @access public
	 * @method void Cree une nouvelle session et son token
	 * @author GB Michel
	 * @version 1.0
	 * @since 15/04/2013
	 */
	private function createSession()
	{
	    // Personnalisation du cookie de session
	    if( $this->_profile->get('SESSION_USE_COOKIE_CFG') == true){
            session_set_cookie_params(
                $this->_profile->get('SESSION_CFG_LIFETIME'),
                $this->_profile->get('SESSION_CFG_PATH'),
                $this->_profile->get('SESSION_CFG_DOMAIN'),
                $this->_profile->get('SESSION_CFG_SECURE'),
                $this->_profile->get('SESSION_CFG_HTTPONLY')
            );
	    }
	    
		// Creation de la session
		session_name( $this->_sessname);
		$fs = session_start();
	
		// marquage de l'ouverture de la session
		self::$_isOpen = true ;
		
		// Creation du token
		$ft= $this->createToken();
	
		
	
		if( isset( $_SESSION, $_SESSION['ss_token'], $_SESSION['ss_tokenname'])){
			return ($ft && $fs);
		}
		else{
			return false ;
		}
	}
	
	/**
	 * @access private
	 * @method Session Constructeur de l'objet Session
	 * @param string $sessionname_str Nom de la session
	 * @param bool $createsess_bool TRUE si on doit creer une session, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	private function __construct( $profilename_str, $createsess_bool)
	{
	    $this->_profile = new Profile($profilename_str);
	    
		$this->_sessname = $this->_profile->get('SESSION_NAME');

		if( !is_null($this->_sessname) 
				&& ($createsess_bool === true)){
			$this->createSession();
		}
	}
	
	
	/**
	 * Retourne l'instance de l'objet session, ci elle n'existe pas on la cree
	 * @static
	 * @access public
	 * @method Session Retourne l'instance courante de la Session
	 * @param string $sessname_str Nom de la session, par défaut vaut _UFO_SESSION_NAME_
	 * @return Session Retourne l'instance courrante
	 * @author GB Michel
	 * @version 1.0
	 * @since 11/04/2013
	 */
	public static function getInstance( $profilename_str = null, $createsess_bool = true)
	{
		if( is_null(self::$_instance)){		    
			self::$_instance = new Session( $profilename_str, $createsess_bool);
		}
				
		return self::$_instance;
	}
	
	/** 
	 * @static
	 * @access public
	 * @method void Ouvre une nouvelle session
	 * @author GB Michel
	 * @version 1.0
	 * @since 19/04/2013
	 */
	public static function initialize($profilename_str)
	{
		// Si une session est ouverte alors que 
		// l'on souhaite en ouvrir une, il y a une erreur
		if( !is_null(self::$_instance)){
			return false;
		}
		
		self::$_instance = new Session( $profilename_str, false);
		self::$_instance->createSession();
		
		return self::$_instance;
	}
	
	/**
	 * @access public
	 * @method Boolean Si la session existait elle est ouverte et certaine donnee sont recuperee, sinon elle est cree
	 * @param String $sessname_str Nom de la session que l'on veut restaurer
	 * @return Boolean Resultat de la restauration, TRUE si reussie, FALSE sinon
	 * @version 1.0
	 * @author GB Michel
	 * @since 12/04/2013
	 */
	public static function restore($profilename_str)
	{	
		// On verifie que la session n'a pas deja ete restore	
		if( (self::$_stateRestore === true) 
			&& !is_null(self::$_instance)){
			
			return self::$_instance ;
		}	
		
		// Si on commence le script par la restauration de la 
		// session, il faut recupere l'instance courrante
		if( is_null(self::$_instance)){
			$o = self::getInstance( $profilename_str, false);
		}
		else{
			$o = self::$_instance;
		}
		
		if( self::$_isOpen === false){
			
		    if( is_null($o->_profile)){
		        // error + exit
		    }
		    
			// Ouverture de la session
			session_name( $o->_profile->get('SESSION_NAME'));
			$f = session_start();
			
			// On verifie quelle existe
			if( $f === false){
				return false;
			}
			self::$_isOpen = true;
		}

		// Verification du token
		$ct = self::checkToken();
		if( $ct === false){
			return false;
		}
		
		if( isset($_SESSION['ss_data'])){
			$o->_data = $_SESSION['ss_data'] ;
		}	
		
		self::$_stateRestore = true;
		
		return self::$_instance ;
	}
	
	
	/**
	 * Mecanisme independant de la creation/restauration,
	 * permettant de verifier si une session existe et si elle
	 * est conforme. Verifie meme si aucune instance de session existe
	 * ------------------------------
	 * @static
	 * @access public
	 * @method boolean Verifie si une session est active sur le serveur
	 * @return boolean Retourne TRUE si une sessionn est active, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 16/04/2013
	 */
	public static function exist($profilename_str)
	{
		$f = false;
		if( self::$_isOpen===false){
		    $prf = new Profile($profilename_str);
		    
			session_name($prf->get('SESSION_NAME'));
			$f = session_start();
			$create = true;
		}
		else{
			$f = true;
			$create = false;
		}
		
		if( $f !== false){
			
			$ct = self::checkToken(false);
			
			if( $create === true){
				session_write_close();
			}
			
			return ( $ct===true)? true : false;
		}
		else{
			return false;
		}
	}
	
	/**
	 * 
	 */
	public static function isOpen()
	{
		return self::$_isOpen;	
	}
	
	/**
	 * @method void Remet a zero la session
	 * @author GB MIchel
	 * @version 1.0
	 * @since 09/07/2013
	 */
	public function reset()
	{
		// regenere la session et supprime l'ancien fichier
		session_regenerate_id(true);
		
		// RaZ propriete
		// *****************
		self::$_isOpen = true;
		
		// Creation du token
		$ft= $this->createToken();
		
		
		 // Personnalisation du cookie de session
		if( $this->_profile->get('SESSION_USE_COOKIE_CFG') == true){
    		session_set_cookie_params(
				$this->_profile->get('SESSION_CFG_LIFETIME'),
				$this->_profile->get('SESSION_CFG_PATH'),
				$this->_profile->get('SESSION_CFG_DOMAIN'),
				$this->_profile->get('SESSION_CFG_SECURE'),
				$this->_profile->get('SESSION_CFG_HTTPONLY')
    		);
		}
		
		
		if( isset( $_SESSION, $_SESSION['ss_token'], $_SESSION['ss_tokenname'])){
			return $ft;
		}
		else{
			return false ;
		}
	}
	
	/** 
	 * @access public
	 * @method void Destruction explicite de la session
	 * @author GB Michel
	 * @version 1.0
	 * @since 11/04/2013
	 */
	public function destroy()
	{
		if( self::$_isOpen===true){

			setcookie( $_SESSION['ss_tokenname'], '', time()-3600, $this->_profile->get('SESSION_PATH'));
			
			$_SESSION = array();
			session_destroy();
			
			$this->_token = null ;
			$this->_tokenname = null ;
			self::$_isOpen = false;
			self::$_stateRestore = false;
			self::$_instance = null;
		}
	}
	
	
	/**
	 * @access public
	 * @method boolean Cree une nouvelle variable de session si elle n'existe pas et fixe sa valeur
	 * @param string $name_str Nom de la variable de session
	 * @param mixed $val_mixed Valeur de la variable de session
	 * @return boolean Retourne TRUE en cas de reussite, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public function setData( $name_str, $val_mixed = null )
	{
		if( is_null( $this->_token) || is_null( self::$_instance)){
			$msg = 'File : '.__FILE__.' , Time : '.date('d-m-Y h:i:s').'';
			ErrorStack::getInstance()->addError( $msg.' , Erreur d\'assignation', _UFO_FATAL_ERROR_);
			Trace::add( _UFO_LOG_LOGIC_, $msg.' , Msg : Impossible de renseigner la variable de session : '.$name_str.'');
			return false ;
		}
		
		if( (is_string($name_str) && ($name_str !== ''))){
			$_SESSION['ss_data'][$name_str] = $val_mixed ;
			return true ;
		}
		else{
			return false ;
		}
	}
	
	
	/**
	 * @access public
	 * @method boolean Supprime une variable de session
	 * @param string $name_str Nom de la variable de session
	 * @return boolean Retourne TRUE en cas de reussite, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public function removeData( $name_str)
	{
		if( is_null( $this->_token) || is_null( self::$_instance)){
			$msg = 'File : '.__FILE__.' , Time : '.date('d-m-Y h:i:s').'';
			ErrorStack::getInstance()->addError( $msg.' , Erreur d\'assignation', _UFO_FATAL_ERROR_);
			Trace::add( _UFO_LOG_LOGIC_, $msg.' , Msg : Impossible de renseigner la variable de session : '.$name_str.'');
			return false ;
		}
		
		if( (is_string($name_str) && ($name_str !== ''))){
			unset( $_SESSION['ss_data'][$name_str]) ;
			return true ;
		}
		else{
			return false ;
		}
	}
	
	
	/**
	 * @access public
	 * @method mixed Retourne le variable de session $name_str
	 * @param string $name_str
	 * @return mixed Contenu de la variable de session, FALSE si elle n'existe pas ou que la session n'existe pas
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	public function getData( $name_str)
	{
		if( (!isset($name_str)) 
			|| (is_null( $this->_token)) 
			|| (!isset($_SESSION['ss_data'][$name_str]))
			|| is_null(self::$_instance) ){
				
			$msg = 'File : '.__FILE__.' , Time : '.date('d-m-Y h:i:s').'';
			ErrorStack::getInstance()->addError( $msg.' , Erreur d\'assignation', _UFO_FATAL_ERROR_);
			Trace::add( _UFO_LOG_LOGIC_, $msg.' , Msg : Impossible de recuperer la variable de session : '.$name_str.'');
			return false;
		}
		
		if( isset($_SESSION['ss_data'][$name_str])){
			return $_SESSION['ss_data'][$name_str];
		}
		else{
			return false;
		}
		
	}	
	
	/**
	 * @access public
	 * @method bool Verifie si une donnee est stockee en session
	 * @param string $name_str Nom de la variable stocke en session
	 * @return bool Retourne TRUE si elle existe, FALSE sinon.
	 * @author GB Michel
	 * @version 1.0
	 * @since 19/04/2013
	 */
	public function issetData( $name_str)
	{
		return ( self::$_isOpen == true)? isset($_SESSION['ss_data'][$name_str]) : false;
	}
	
	/**
	 * @access public
	 * @method Boolean Regenere l'id de la session, detruit l'ancien fichier, detruit l'ancien token et en recree un
	 * @return Boolean Vaut TRUE si reussie, FALSE en cas d'erreur
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	public function regenerateID()
	{
		if( is_null(self::$_instance)){
			return false ;
		}	
		
		// Regen ID + destruction fichiers
		session_regenerate_id( true);
		
		// Ecrase l'ancien token
		setcookie( $this->_tokenname);
		
		// Cree un nouveau token
		$this->createToken();
		
		return true;
	}
}

?>
