<?php

namespace Ufo\Form;

class Form
{
	const _FORM_POST = '_POST';
	const _FORM_GET = '_GET';
	
	public $name = null ;
	public $gdsUniq = null ;
	
	
	public $uniqName = null;
	
	public $typeHTTP = 'POST' ;
	
	public $logicalFields = null ;
	public $realFields = null ;
	public $bindFields = array();
	
	/*
	 * Tokens
	 */
	private $_time_token = null;
	private $_csrf_token = null;
	
	/*
	 * Crypt module 
	 */
	private $_pubkey = null;
	private $_prikey = null;	
	
	
	
	public function __construct( $httmethod_str = 'POST', $fieldnames = array())
	{
		
	}
	
	
	/**
	 * @access public
	 * @method boolean Definit la methode HTTP de transmition des donnees
	 * @param string $type_str Methode a utiliser: GET ou POST
	 * @return boolean Retourne TRUE si ok, FALSE si la methode n'est ni GET ni POST
	 * @author GB Michel
	 * @version 1.0
	 */
	public function setTypeHTTP( $type_str)
	{
		if( !in_array( $type_str, array('POST','GET'))){
			return false ;
		}
		$this->typeHTTP = $type_str ;
		return true ;
	}
	
	
	/**
	 * Ajoute un champ correspondant a une propriete d'un objet 
	 * dans un formulaire.
	 */
	public function addField( $objettype_str, $property_str = array(), $useBindField = false)
	{
		if( !class_exists( $objettype_str, true)){
			return false ;
		}
		
		$o = new $objettype_str ;
		$t = $o->getTemplate( $property_str);
		
		foreach( $t as $ppt=>$tpl)
		{
			$this->logicalFields[$ppt] = $tpl ;
			
		}
	}
	

	
	/**
	 * Cree un formulaire unique, en inserant un champ dans le formulaire
	 * dont le nom et la valeur sont calcule a partir d'une chaine aleatoire
	 * @access public
	 * @method boolean Cree un champ utilise pour valider un formulaire unique
	 * @return boolean Retourne TRUE en cas de succes de la creation, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public function useUniqForm()
	{
		$this->gdsUniq = \Ufo\Util\Util::randomString(128);
		
		$s = substr( $this->gdsUniq, 0, 3).date('d-m-Y h:i:00').substr( $this->gdsUniq, 9, 11);
		$n = substr( $this->gdsUniq, 3, 9);
		
		if( !in_array( $n, array_keys($this->realFields))){
		    $this->uniqName = $n;
			$this->realFields[$n] = array('type'=>'hidden','value'=>md5( $s));
			return true ;
		}
		
		return false;
	}
	
	/**
	 * @access public
	 * @method boolean Valide un formulaire unique
	 * @param string $salt_str Grain de sel utilise pour genere le formulaire
	 * @param array $values_array Tableau associatif, nom du champs => valeur, contenant les donnees recu
	 * @return boolean Retourne le resultat de la validation, TRUE si valide, FALSE sinon
	 * @author GB Michel
	 * @version 1.0
	 */
	public function checkUniqForm( $salt_str, $values_array)
	{
		// calcul du nom du champ a partir du GDS
		$f = substr( $salt_str, 3, 9);
	
		// verification de la presence du champs dans les donnees soumises
		if( !in_array( $f, array_keys( $values_array))){
			return false ;
		}
	
		// verification de la validite sous 10 minutes
		$p = substr( $this->gdsUniq, 0, 3);
		$s = substr( $this->gdsUniq, 9, 11);
		$valid = range( 0, 10);
		$check = false ;
		foreach( $valid as $v)
		{
			$check |= ($values_array[$f] == md5( $p.date('d-m-Y h:i:00', mktime()+($v*60)).$s));
		}
	
		return $check ;
	}
	
	/**
	 * @method void Ajoute un nouveau champs avec un nom aleatore au formulaire
	 * @param string $fieldname_str Nom du champs en clair
	 * @since 08/04/2013 
	 */
	public function setBindFields( $fielsname_str)
	{
		$s = uniqid();
		if( !in_array( $s, $this->bindFields) &&
			!in_array( $fielsname_str, array_keys($this->bindFields))){
			
			$this->bindFields[$fielsname_str] = $s ;
		}
	}
	
	/**
	 * @method string Retourne le nom aleatoire du champ 
	 * @param string $fieldname_str Nom du champs en clair 
	 * @return string Nom aleatoire utilise dans le formulaire HTML
	 * @since 08/04/2013
	 */
	public function getBindNameFor( $fieldname_str)
	{
		return $this->bindFields[$fieldname_str];
	}
	
	/**
	 * @method string Retourne la valeur d'un champs avec un nom aleatoire
	 * @param string $cleanfieldname_str Nom du champs en clair 
	 * @param string $method_str Methode d'envoi du formulaire
	 * @return string Retourne la valeur du champs
	 * @since 08/04/2013
	 */
	public function getBindFieldValue( $cleanfieldname_str, $method_str)
	{
	    if($method_str=='POST'){
	        return $_POST[$this->bindFields[$cleanfieldname_str]];
	    }
	    elseif($method_str=='GET'){
	        return $_GET[$this->bindFields[$cleanfieldname_str]];
	    }
	    else{
	        return false;
	    }
	}
	
	
	
	/**
	 * Retourne une description complete du formulaire
	 * afin de pourvoir recree le formulaire avec exactement la
	 * meme configurataion. Indispensable lors de l'utilisation
	 * des bindFields
	 * @access public
	 * @method array Retourne une description complete du formulaire
	 * @return array Tableau associatif multidimensionel
	 * 	public function getConfig()
	{
		
	}
	 */

	
	/**
	 * Charge une configuration.
	 * Exemple de config:
	 * bindName=>(Name,Value,Objet,PropertyObj);
	 * public function loadConfig()
		{
		
		}
	 */
	
	
	
	/**
	 * @access public
	 * @method void Definie le nom du formulaire
	 * @param string $formname_str Nom du formulaire
	 * @author GB michel
	 * @version 1.0
	 */
	public function setName( $formname_str)
	{
		$this->name = $formname_str ;
	}
	
	/**
	 * @access public
	 * @method string Retourne le nom du formulaire
	 * @return string Retourne le nom du formulaire, NULL s'il n'est pas defini
	 * @author GB michel
	 * @version 1.0
	 */
	public function getName()
	{
		if( $this->name == null){
			return false ;
		} 
		return $this->name ;
	}
	
	/**
	 * @access public
	 * @method string Retourne le grain de sel utilise
	 * @return string Retourne le grain de sel utilise, NULL s'il n'est pas defini
	 * @author GB michel
	 * @version 1.0
	 */
	public function getSalt()
	{
		return $this->gdsUniq ;
	}
	
	

	/**
	 * @access public
	 * @method array Retourne un tableau dont chaque clef est associe a la valeur du champs
	 * @param const $typeHTTP_const Method utilise pour le passage des donnees
	 * @param array $wrap_arr Tableau associatif ou la clef est la clef finale, et la valeur le nom du champs dont on veux recuperer la valeur
	 * @return array Tableau associant un nom a la valeur du champs correspondant, FALSE en cas d'erreur
	 * @author GB Michel
	 * @version 1.0
	 */
	public function getFieldsArray( $typeHTTP_const, $wrap_arr=array())
	{
		if( !is_array($wrap_arr)){
			return false;
		}
		
		($typeHTTP_const == 'POST')? $t = &$_POST : $t = &$_GET ;
			
		$tmp = array();
		if( count($wrap_arr)==0){
			$tmp = $t;
		}
		else{
			foreach( $wrap_arr as $name=>$field)
			{
				if( isset($t[$field])){
					$tmp[$name] = $t[$field];
				}
				else{
					$tmp[$name] = '';
				}
				
			}
		}

		return $tmp;
	}
	
	/**
	 * 
	 * @param unknown_type $objet_obj
	 * @param unknown_type $typeHTTP_const
	 * @param unknown_type $wrap_arr
	 */
	public function getFieldToObject( &$objet_obj, $typeHTTP_str='POST', $wrap_arr=array(), $usealias_bool)
	{
		if( !is_array($wrap_arr) || !is_object($objet_obj) 
			|| !method_exists($objet_obj,'setData')){
			return false;
		}
		
		($typeHTTP_str == 'POST')? $t = &$_POST : $t = &$_GET ;
		$tpl = array_keys( $objet_obj->getTemplate());
		$w = array_combine( $tpl, $tpl);
		
		foreach( $wrap_arr as $k=>$f)
		{
			$w[$k] = $f ;
		}
			
		$prop = array();
		foreach( $w as $ppt=>$field)
		{
			if( property_exists( $objet_obj, $ppt) && isset($t[$field])){
				$prop[$ppt] = $t[$field] ;
			}
		}
		
		return $objet_obj->setData( $prop);	
	}

	
	/**
	 * @access public
	 * @method boolean Verifie si des donnees ont ete passees en POST ou GET
	 * @return boolean Retour TRUE si des donnees ont ete passees, FALSE sinon
	 * @version 1.0
	 */
	public function isSubmit()
	{
		if( (count($_POST)>0) || (count($_GET)>0)){	
			return true;
		}
		else{
			return false;
		}
	}
	
	
	/**
	 * 
	 * @param unknown $name_str
	 * @return boolean
	 */
	public function recordAs($name_str)
	{
		return Register::addForm($name_str, $this);
	}
	
}

?>