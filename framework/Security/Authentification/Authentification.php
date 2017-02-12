<?php

namespace Ufo\Authentification\Security;

use Ufo\Session\Session as Session; 
use Ufo\Captcha\Captcha as Captcha;
use Ufo\Form\Form as Form;
use Ufo\User\Account as Account;
use Ufo\User\User as User;

/**
 * Authentification est un objet persistant avec plusieurs etats,
 * il renferme tous les mecanismes intervenant lors de l'authentification.
 * L'objet est instancié lors de la creation du formulaire d'authentification,
 * et est detruit a la fin de la procedure quelque soit le resultat.
 * L'objet gere la session et le captcha.
 * 
 * GB. MICHEL
 * V1.0 
 */
class Authentification 
{
	/**
	 * @static
	 * @var Authentification Instance unique de la classe
	 */
	private static $_instance = null;
	
	private $useCaptcha = false ;
	
	
	public $result = array('res'=>false,'msg'=>'');
	
	private $_idprs = null ;
	private $_captcha = null ;
	private $_forms = null ;
	
	// Liste des etats de l'authentification
	public $flags = array(
	    'restore'=>false,
	    'formsChecked'=>false,
	    'captchaChecked'=>false,
	    'accountChecked'=>false
	);

	
	/**
	 * @access
	 * @method void Constructeur
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	private function __construct()
	{}
	
	
	/**
	 * @static
	 * @access public 
	 * @method Authentification Retourne l'instance du singleton
	 * @return Authentification Objet authentification
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	public static function getInstance()
	{
		if( is_null(self::$_instance)){
			self::$_instance = new StandardAuthentification();
		}
		
		return self::$_instance;
	}
	
	
	 /**
	 * @access public
	 * @method boolean Permet de recuperer la session d'authentification et de restaurer l'objet Authentification avec ses parametre.
	 * @return boolean Retourne TRUE en cas de succes de restauration de l'objet Authentification, FALSE en cas d'erreur
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/03/2013
	 */
	public static function restore()
	{		
		// restauration de la session d'authentification
		$sess = Session::restore();
		
		if( is_null($sess) || ($sess===false)){
			return false;
		}
		
		// restauration de l'objet authentification
		if( $sess->getData('ss_obj_auth') === false){
			return false;	
		}
		
		self::$_instance = unserialize($sess->getData('ss_obj_auth'));
		self::$_instance->flags['restore'] = true ;
		
		return self::$_instance;
	}
	
	
	/**
	 * @access public
	 * @method void Definit si on doit utiliser ou non un captcha
	 * @author GB Michel
	 * @version 1.0
	 * @since 02/04/2013
	 */
	public function useCaptcha()
	{
		$this->useCaptcha = true;
		
		$i = 0;
		while( $i<3 ){
		    try{
		        $this->_captcha = new Captcha();
		        break;
		    }catch( Exception\AuthentificationCaptchaException $e){
		        $i++;
		    }
		}
	}
	
	
	/**
	 * @access public
	 * @method void Initialise l'objet, en vue de produire l'acte d'authentification
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	public function initialize()
	{
		// creation du formulaire d'authentification
		// avec nom du formulaire et des champs aleatoire
		$this->_forms = new Form();
		$this->_forms->setTypeHTTP('POST');
		$this->_forms->setBindFields('login');
		$this->_forms->setBindFields('passwd');
		$this->_forms->setBindFields('captcha');
		$this->_forms->recordAs('auth_form');
		
		// stockage de l'objet en session
		$this->stock();
	}
	
	
	/**
	 * @access public
	 * @method boolean Valide si les donnees du formulaire sont au format attendue, et met a jour l'etat
	 * @return boolean Retourne TRUE si le formulaire est recevable, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 08/04/2013
	 */
	public function checkForms()
	{
		if( $this->flags['restore'] !== true ){
			$this->result = array('res'=>false,'msg'=>'Echec de connexion');
			return false;
		}
		
		// Check captcha en premier
		if( $this->useCaptcha == true){
		    $f = $this->_captcha->check($this->_forms->getBindFieldValue('passwd','POST'));
		    if( $f !== true){
		        $this->flags['captchaChecked'] = false ;
		        $this->result = array('res'=>false,'msg'=>'Echec de connexion');
		        return false;
		    }
		}
		
		// chargement des donnee du formulaire, dans l'objet formulaire
		// precedement configure
		$f1 = Account::checkLoginSyntax( htmlentities( $this->_forms->getBindFieldValue('login','POST')));
		$f2 = Account::checkPasswdSyntax( htmlentities( $this->_forms->getBindFieldValue('passwd','POST')));
		
		if( ($f1 && $f2) === true ){
			$this->flags['formsChecked'] = true;
			return true;
		}
		else{
			$this->result = array('res'=>false,'msg'=>'Echec de connexion');
			return false;
		}
	}
	
	
	/**
	 * @access public
	 * @method boolean Mecanisme d'authentification
	 * @return boolean Resultat de l'authentification
	 * @author GB Michel
	 * @version 1.0
	 * @since 08/04/2013
	 */
	public function checkAuthentification()
	{
		
		if( $this->flags['formsChecked'] !== true ){
			$this->result = array('res'=>false,'msg'=>'Echec de connexion');
			return false;
		}
		

		
		
		// Verification du compte
		$id_prs = Account::checkAccount( $this->_forms->getBindFieldValue( 'login', 'POST'),
									$this->_forms->getBindFieldValue( 'passwd', 'POST'));
									
		if( $id_prs === false){
			// LOGS + MESSAGES
			$this->flags['accountChecked'] = false;
			return false;
		}
		
		$this->_idprs = (int)$id_prs;
		$this->flags['accountChecked'] = true;
		return true ;
	}
	
	/**
	 * Sérialise l'objet courant et le stocke dans la variable de session
	 * @method boolean Serialise l'objet et le stocke dans la variable de session
	 * @return boolean TRUE en cas de succes, FALSE sinon
	 * @version 1.0
	 * @author GB Michel
	 * @since 08/04/2013
	 */
	public function stock()
	{
		
		// Recuperation de la session
		//$sess = Session::getInstance( _UFO_SESSION_NAME_, true);
		$sess = Session::initialize();
		if( $sess === false){
			$sess = Session::getInstance( _UFO_SESSION_NAME_, false);
		}
		/*
		$data = array('_forms'=>$this->_forms,
				'_captcha'=>$this->_captcha,
				'useCaptcha'=>$this->useCaptcha,
				'result'=>$this->result,
				'flags'=>$this->flags);
		*/		
		// Stockage des parametre de l'insatance dans la session
		// $sess->setData( 'ss_obj_auth', serialize($data));	
		$sess->setData( 'ss_obj_auth', serialize($this));
		
		
	}
	

	
	/**
	 * @access public
	 * @method void Detruit l'objet Authentification et tous les autres objet interne
	 * @author GB Michel
	 * @version 1.0
	 * @since 08/04/2013
	 */
	public function destroy()
	{
		$this->_forms = null;
		
		// La destruction du captcha entraine la suppression de l'image
		$this->_captcha->destroy();
		$this->_captcha = null;
	}
	
	/**
	 * Surcharge de la methode magique __destruct pour etre sur
	 * que l'ojbet et tout ses composants soient detruis
	 * @access public
	 * @method void Destructeur
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	public function __destruct()
	{
		//$this->destroy();
	}
	
	
	/**
	 * @access public
	 * @method string|boolean Retourn l'URL de l'image du captcha
	 * @return string|boolean URL de l'image si elle existe, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 08/04/2013
	 */
	public function getCaptchaPath()
	{
		if( !is_null($this->_captcha)){
			return $this->_captcha->getImagePath();
		}
		else{
			return false;
		}
	}
	
	/**
	 * @access public
	 * @method array Retourne le resultat de l'authentification et le message
	 * @return array Tableau associatif de la forme : {'res'=>false,'msg'=>''}
	 * @author GB Michel
	 * @version 1.0
	 * @since 09/04/2013
	 */
	public function getResult()
	{
		return $this->result ;
	}
	
	
	/**
	 * @access public
	 * @method boolean Gere le change de session et l'ouverture de la session utilisateur
	 * @return boolean Resultat de l'ouverture de la session utilisateur, TRUE si OK, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	public function openUserSession()
	{
		if( $this->flags['accountChecked'] === false){
			return false;
		}

		$sess = Session::getInstance();
		$sess->regenerateID();
		
		User::initialize( $this->_idprs);
		
		//$sess->setData( 'ss_obj_auth', null);
		$this->destroy();
		
		return true;
	}
	
	// FONCTION POUR LES TESTS
	public function getCaps()
	{
		return $this->_captcha->getValue();
	}
	
	public function getForm()
	{
		
	}

}
?>
