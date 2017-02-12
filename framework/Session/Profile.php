<?php

namespace Ufo\Session;

use Ufo\Security\Check as Check;

/**
 * 
 * @author gb-michel
 *
 */
class Profile
{
    private $_profile_name;
    private $_loaded = false;
    
    private $_auth=  array(
        'TOKEN_GDS','TOKEN_NAME','TOKEN_REGEN',
        'SESSION_NAME','SESSION_EXPIRE','SESSION_PATH','CASESENSITIVE','SESSION_REGEN',
        'SESSION_CONTROL','SESSION_CONTROL_TIMEOUT',
        'SESSION_USE_COOKIE_CFG','SESSION_CFG_LIFETIME','SESSION_CFG_PATH','SESSION_CFG_DOMAIN',
        'SESSION_CFG_SECURE','SESSION_CFG_HTTPONLY','USE_DOUBLE_TOKEN'
    );
    
    private $_TOKEN_GDS = null;
    private $_TOKEN_NAME = null;
    private $_TOKEN_REGEN = null;
    private $_SESSION_NAME = null;
    private $_SESSION_REGEN = null;
    private $_SESSION_PATH = null;    
    private $_SESSION_EXPIRE = null;    
    private $_SESSION_CONTROL = null;
    private $_SESSION_CONTROL_TIMEOUT = null;
    private $_SESSION_USE_COOKIE_CFG = null;
    private $_SESSION_CFG_LIFETIME = null;
    private $_SESSION_CFG_PATH = null;
    private $_SESSION_CFG_DOMAIN = null;
    private $_SESSION_CFG_SECURE = null;
    private $_SESSION_CFG_HTTPONLY = null;
    private $_USE_DOUBLE_TOKEN = null;


    
    /**
     * 
     * @param unknown $profilename_str
     */
    public function __construct( $profilename_str)
    {
        if( Check::pureText($profilename_str,true,false,10) 
            && file_exists(_UFO_PROFILES_SESS_DIR_.$profilename_str.'.php')){           
            $cfg = include(_UFO_PROFILES_SESS_DIR_.$profilename_str.'.php');
        }
        elseif( file_exists(_UFO_UFO_INCLUDEPATH_.'Session/Profile/default.php')){            
            $cfg = include(_UFO_UFO_INCLUDEPATH_.'Session/Profile/default.php');
        }
        else{
            throw new Exception\ImportProfileException('Custom profile not found ! Default UFO\'s profile not found !');
            return false;
        }

        foreach( $cfg as $key=>$val){
            if( in_array($key,$this->_auth)){
                $s = '_'.$key;
                $this->$s = $val;
            }
        }
        
        $this->_profile_name = $profilename_str;
        $this->_loaded = true;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isLoaded()
    {
        return $this->_loaded;
    }
    
    /**
     * 
     * @return unknown
     */
    public function getProfilName()
    {
        return $this->_profile_name;
    }

    
    /**
     * 
     * @param unknown $ppt_str
     */
    public function get($ppt_str)
    {
        if( in_array($ppt_str,$this->_auth)){
            //err
        }
        else{
            $s = '_'.$ppt_str;
            return $this->$s;
        }
        
    }
    
    
} 
