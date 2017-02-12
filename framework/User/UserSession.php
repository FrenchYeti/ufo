<?php

namespace Ufo\User;

use Ufo\Session\Session;
use Ufo\Session\PersistantInterface;



/**
 * Post-authentification, toutes les taches de verification des droits
 * d'acces et la gestion des session passe par cette classe.   
 * 
 * @package Core
 * @author GB Michel
 * @since 14/04/2013
 */
abstract class UserAbstract implements PersistantInterface
{	
	/**
	 * @static
	 * @access private
	 * @var Utilisateur Instance de la classe ( pour conserver le pattern Singleton)
	 */
	private static $_instance = null;
	private static $_stateRestore = false;
    private $_role = null;
	private $_account = null;
	
	/**
	 *
	 * @static
	 *
	 * @var string Name of db's profile
	 */
	public $_db_profile;
	
	public $_sess_profile;
	
	/**
	 *
	 * @static
	 *
	 * @var array Template of table ( name + prefix )
	 */
	private $_tpl_table = array(
	    'name' => '',
	    'prefix' => ''
	);
	
	/**
	 *
	 * @static
	 *
	 * @var array Template of columns
	*/
	private $_tpl_columns;
	
	/**
	 *
	 * @var int ID of entity
	 */
	protected $_id = null;
	protected $_passwd = null;
	protected $_login = null;
	protected $_actif = true;
	
	/**
	 * @access private
	 * @method void Constructeur
	 * @author GB Michel
	 * @version 1.0
	 * @since 14/03/2013
	 */
	private function __construct()
	{}	
	
	/**
	 * (non-PHPdoc)
	 * @access public
	 * @method boolean Detruit proprement la session Utilisateur
	 * @return boolean Retourne TRUE si la destruction est reussie, FALSE en cas d'erreur
	 * @author GB Michel
	 * @version 1.0
	 * @since 16/04/2013
	 * @see iPersistant::destroy()
	 */
	public function destroy()
	{
		if( self::$_stateRestore === true){
			
			$this->_account = null;
			
			// Fermeture de la session
			$sess = Session::getInstance( _UFO_SESSION_NAME_, false);
			
			return $sess->destroy();
		}
		else{
			return false ;
		}		
	}
	
	/**
	 * @access public
	 * @method Utilisateur Retourne l'instance unique de la classe (singleton)
	 * @return Utilisateur Instance de la classe
	 * @author GB Michel
	 * @version 1.0
	 * @since 15/04/2013
	 */
	public static function initialize($account_obj,$role_obj)
	{
		$usr = self::getInstance();


		// Personne liee a l'utilisateur
		$usr->_account = $account_obj;
		$usr->_role = $role_obj;
		
		if( is_null($usr->_account->getID())){
			return false;
		}
		
		// Access de l'utilisateur	
		$usr->_access = $usr->_person->getAccess();	
		$usr->stock();
		
		return self::$_instance ;
	}
	
	/**
	 * @static
	 * @access public
	 * @method Utilisateur Retourne l'instance unique de la classe (singleton)
	 * @return Utilisateur Instance de la classe
	 * @author GB Michel
	 * @version 1.0
	 * @since 15/04/2013
	 */
	public static function getInstance()
	{
		if( is_null( self::$_instance)){
			self::$_instance = new UserAbstract();
		}
		
		return self::$_instance;
	}	
	
	/**
	 * @static
	 * @access public
	 * @method Utilisateur Restore l'utilisateur de la session
	 * @return Utilisateur Instance de la classe
	 * @author GB Michel
	 * @version 1.0
	 * @since 15/04/2013
	 */
	public static function restore()
	{
		if( (self::$_stateRestore==true) 
				&& !is_null(self::$_instance)){
			
			return self::$_instance;
		}
		
		$sess = Session::restore();
		
		if( $sess == false){
			return false;
		}

		//var_dump($sess);
		
		self::$_instance = unserialize( $sess->getData( 'ss_current_user'));
		// var_dump($sess->getData( 'ss_obj_account'));
		// en cas d'erreur de de-serialization
		if( is_null(self::$_instance)){
			return false;
		}
		
		self::$_stateRestore = true;
		
		return self::$_instance ;
	}
	
	/**
	 * @method void Redirige vers la page d'accueil, qui fera les verification necessaire
	 * @author GB Michel
	 * @since 06/05/2013
	 * @version 1.0
	 */
	public static function eject()
	{
		header('Location: index.php');	
	}
	
	/**
	 * @static
	 * @access public
	 * @method boolean Regarde si une session utilisateur existe
	 * @return booelan TRUE si une session est ouverte, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 16/04/2013
	 */
	public static function exist()
	{
		// Utilisateur existant, deja instancie et restaure
		if( !is_null(self::$_instance) 
				&& (self::$_stateRestore===true)){
			return true;
		}
		
		// utilisateur restorable
		if( self::isRestorable()===true){
			return true;
		}
		
		return false;
	}
	
	/**
	 * @method bool Verifie si l'utilisateur est restorable, cad si il existe en session
	 * @return bool Retourn TRUE s'il est restorable, FALSE sinon.
	 * @author GB Michel
	 * @version 1.0
	 * @since 19/04/2013
	 */
	public static function isRestorable()
	{
		if( Session::exist()===false) return false;
		
		if( Session::isOpen()){
			$sess = Session::getInstance($this->_sess_profile, false);
		}
		else{
			
			$sess = Session::restore();
			if( $sess==false){
				return false;
			}
		}

		
		$f = $sess->issetData('ss_obj_account');
		//$sess->destroy();
		
		return $f;
	}
	
	/**
	 * @method void Stock l'utilisateur dans la session
	 */
	public function stock()
	{
		$sess = Session::getInstance($this->_sess_profile);
		$sess->setData('ss_current_user',serialize($this));
		
	}
	
	 
    /**
     * @method Account Return Account
     * @return NULL
     */
	public function getAccount()
	{
		return $this->_account;
	}
	
	
	public function getSession()
	{
		if( self::$_stateRestore === true){
			return Session::getInstance();
		}
		else{
			return false ;
		}
	}
	

	/**
	 *
	 * @access private
	 * @method boolean Met a jour une donnee d'un compte, et uniquement cette donnee
	 * @param string $columnname_str
	 *            Nom de la colonne mise a jour
	 * @param mixed $value_mixed
	 *            Valeur a inserer
	 * @param const $typePDO_const
	 *            Constante PDO du type de donnee a utiliser dans bindParam
	 * @return boolean Resulta de la mise a jour, TRUE si ok, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 09/04/2013
	 */
	abstract private function updateSingleField($columnname_str, $value_mixed, $typePDO_const);
	
	/**
	 *
	 * @access private
	 * @method string Retourne le mot de passe hache
	 * @param string $mdp_str
	 *            Mot de passe en clair
	 * @param int $time_int
	 *            Timestamp UNIX
	 * @return string Mot de passe hache
	 * @since 09/04/2013
	*/
	private static function carouble($mdp_str, $time_int)
	{
	    //$t0 = (int)$time_int;
	    $s0 = (string)$time_int;
	    $m0 = sha1($mdp_str);
	    
	    $mdp1 = substr( $m0, 0, 10).substr( $s0, 0, 3);
	    $mdp2 = substr( $m0, 10, 10).substr( $s0, 3, 2);
	    $mdp3 = substr( $m0, 20, 10).substr( $s0, 5, 3);
	    $mdp4 = substr( $m0, 30, 10).substr( $s0, 8, 2);
	    
	    $mdp1 = str_rot13($mdp4);
	    $mdp2 = str_rot13($mdp3);
	    $mdp3 = str_rot13($mdp1);
	    $mdp4 = str_rot13($mdp2);
	    
	    return sha1($mdp1.$mdp2.$mdp3.$mdp4);
	}
	
	/**
	 *
	 * @method boolean Verifie la syntaxe du login fourni
	 * @param string $login_str
	 *            Chaine de caractere du login
	 * @return boolean TRUE si la syntaxe est correcte, FALSE sinon
	 * @since 08/04/2013
	*/
	abstract public static function checkLoginSyntax($login_str);
	
	/**
	 *
	 * @method boolean Verifie la syntaxe du mot de passe fourni
	 * @param string $passwd_str
	 *            Mot de passe en clair
	 * @return boolean TRUE si la syntaxe est correcte, FALSE sinon
	 * @since 08/04/2013
	*/
	abstract public static function checkPasswdSyntax($passwd_str);
	
	/**
	 *
	 * @access public
	 * @method boolean Modifie le mot de passe du compte
	 * @param
	 *            string Nouveau mot de passe, laisser vide pour une generation automatique
	 * @return boolean Retourne TRUE en cas de succes, FALSE sinon
	 * @since 06/04/2013
	*/
	abstract public function updatePasswd($newmdp_str = null);
	
	/**
	 *
	 * @access public
	 * @method boolean Cree nouveau compte pour la personne idPRS
	 * @return boolean Resultat de la creation du compte
	 * @author GB Michel
	 * @version 1.0
	*/
	abstract public function create($pwd_str = null, $login_str = null);
	
	/**
	 *
	 * @static
	 *
	 * @access public
	 * @method boolean Valide le login et le mot de passe
	 * @param string $login_str
	 *            Login a tester
	 * @param string $password_str
	 *            Mot de passe a tester
	 * @return boolean Si la validation reussi, une instance (remplie) de la classe est retournee, sinon FALSE
	 * @since 19/12/2013
	*/
	abstract public static function checkAccount($login_str, $password_str);
	
	
	/**
	 *
	 * @access public
	 * @method boolean Desactive le compte
	 * @return boolean Resultat de la desactivation
	 * @since 09/04/2013
	 */
	public function desactivateAccount()
	{
	    $f = $this->updateStatutAccount(false);
	    if ($f == false) {
	        throw new Exception\AccountException('Echec de desactivation du compte',_UFO_LOG_ACCOUNT_);
	    }
	
	    return $f;
	}
	
	/**
	 *
	 * @access public
	 * @method boolean Active le compte
	 * @return boolean Resultat de l'activation
	 * @since 09/04/2013
	 */
	public function activateAccount()
	{
	    $f = $this->updateStatutAccount(true);
	    if ($f == false) {
	        throw new Exception\AccountException('Echec de d\'activation du compte',_UFO_LOG_ACCOUNT_);
	    }
	
	    return $f;
	}
	
	
	
	/**
	 *
	 */
	abstract public function updateStatutAccount($actif_bool);
}
?>
