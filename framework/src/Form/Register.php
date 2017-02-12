<?php

namespace Ufo\Form;

use Ufo\Session\Session;
use Ufo\User\UserManager;


class FormAlreadyRegistredException extends \Exception {}


class Register
{
	private static $_instance = null;
	
	private $_forms = array();
	
	private $_preventSave = false;
	/**
	 * 
	 */
	private function __construct(){}	
	private function __clone(){}
	
	
	
	/**
	 * 
	 */
	public static function getInstance()
	{    
		if( self::$_instance == null){		    
		    
		    
		    $session = UserManager::getSession();
		    if( $session !== null){
		        
		        if( $session->issetDataObject('form_register')){
		            self::$_instance = $session->getDataObject('form_register');
		        }
		        else{
		            self::$_instance = new Register();
		        }	        
		    }
		    else{
		        self::$_instance = new Register();
		    }
		}
		
		return self::$_instance;
	}
	
	public function preventSave($bool){
	    $this->_preventSave = $bool;
	}
	
	public function save()
	{
		UserManager::getSession()->setDataObject('form_register',$this);	
	}
	
	/**
	 * 
	 * @param string $name_str
	 * @return multitype:|NULL
	 */
	public static function getForm( $name_str)
	{
		$reg = self::getInstance();
		if( isset($reg->_forms[$name_str])){
			return $reg->_forms[$name_str];
		}
		else{
			return null;
		}
	}
	
	/**
	 * 
	 * @param string $name_str
	 * @param Form $form_obj
	 */
	public static function addForm( $name_str, $form_obj)
	{
		$reg = self::getInstance();
		
		if( isset($reg->_forms[$name_str]) && ($reg->_forms[$name_str] !== null) ){
			throw new FormAlreadyRegistredException("Cannot add form to register : $name_str is already registred");
			return false;
		}
		else{
			$reg->_forms[$name_str] = $form_obj;
		    if($reg->_preventSave == false){
			    self::$_instance->save();
			}
			return true;
		}		
	}
	
	
	public static function removeForm( $name_str)
	{
		$reg = self::getInstance();
		
		if( isset($reg->_forms[$name_str]) && ($reg->_forms[$name_str] !== null)){
			$reg->_forms[$name_str]->destroy();
			$reg->_forms[$name_str] = null;
			return false;
		}
		
		return true;
	}
	
	public static function truncate()
	{
	    $session = UserManager::getSession();
	    if($session !== null){
	        $session->removeDataObject('form_register');
	        if(self::$_instance == null){
	             self::$_instance = new Register();
	             self::$_instance->save();
	        }
	        else{
	            $reg = self::$_instance;
	             
	            foreach($reg->_forms as $name=>$frm)
	            {
	                $reg->_forms[$name] = null;
	            }
	            $reg->save();
	        }
	    }
	}
}


?>