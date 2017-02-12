<?php
namespace Ufo\Db;

use Ufo\Security\Check as Check;
use Ufo\Bootloader as Bootloader;
use Ufo\Error\DbException as DbException;

/**
 *
 * @author gb-michel
 *
 */
class ProfileException extends DbException
{
    public function __construct( $calledmethod_str = '', $message_str = '', $code = DbException::STANDARD_LVL)
    {
        parent::__construct('Ufo\Db\Profile','
            -- On : <i>'.$calledmethod_str.'</i> <br>
            -- Exception caught : <i>'.get_class($this).'</i> <br>
            -- Message : <i>'.$message_str.'</i><br>
            -- File : '.$this->getFile().' at line :'.$this->getLine().'<br>
        ',$code);
    }
}

/**
 *
 * @author gb-michel
 *        
 */
class Profile
{    
    private $_profile_name;
    private $_loaded = false;
    
    private $_auth=  array('DBMS','NAME','SERVER','SERVER_PORT','USER','PASS','CASESENSITIVE','OPE_CREATE','OPE_READ','OPE_UPDATE','OPE_DELETE');
    
    private $_DBMS = null;
    private $_NAME = null;
    private $_SERVER = null;
    private $_SERVER_PORT = null;
    private $_USER = null;
    private $_PASS = null;
    private $_CASESENSITIVE = null;
    private $_OPE_CREATE = null;
    private $_OPE_READ = null;
    private $_OPE_UPDATE = null;
    private $_OPE_DELETE = null;
    

    private function checkProfileName( $profilename_str)
    {
    	// internals/
    	if( substr($profilename_str,0,10) == 'internals/'){
    		if( in_array($profilename_str,Bootloader::$_internals)){
    			return true;
    		}
    		else{
    			return false;
    		}
    	}
    	else{
    		return Check::specificPureText($profilename_str,'_',true,false,100);
    	}
    }
    
    /**
     * 
     * @param unknown $profilename_str
     */
    public function __construct( $profilename_str)
    {
        if( $this->checkProfileName($profilename_str)){
            
            if(file_exists(_UFO_PROFILES_DB_DIR_.$profilename_str.'.php')){
            
                $cfg = include(_UFO_PROFILES_DB_DIR_.$profilename_str.'.php');
                
                foreach( $cfg as $key=>$val){
                    if( in_array($key,$this->_auth)){
                        $s = '_'.$key;
                        $this->$s = $val;
                    }
                }
                
                $this->_profile_name = $profilename_str;
                $this->_loaded = true;
            }
            else{
                throw new ProfileException('Profile::__construct()','Profile file not found',DbException::FATAL_LVL);
            }
        }
        else{
            throw new ProfileException('Profile::__construct()','Incorrect profile\'s filename',DbException::FATAL_LVL);
        }
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
    
    public function getDBMS() { return $this->_DBMS; }
    public function getNAME() { return $this->_NAME; }
    public function getSERVER() { return $this->_SERVER; }
    public function getSERVER_PORT() { return $this->_SERVER_PORT; }
    public function getUSER() { return $this->_USER; }
    public function getPASS() { return $this->_PASS; }
    public function getCASE() { return $this->_CASESENSITIVE; }
    
    public function canREAD()
    {
        if( $this->_OPE_READ !==  true){
            return false;
        }
        else{
            return true;
        }
    }
    
    public function canCREATE()
    {
        if( $this->_OPE_CREATE !==  true){
            return false;
        }
        else{
            return true;
        }
    }
    
    public function canUPDATE()
    {
        if( $this->_OPE_UPDATE !==  true){
            return false;
        }
        else{
            return true;
        }
    }
    
    public function canDELETE()
    {
        if( $this->_OPE_DELETE !==  true){
            return false;
        }
        else{
            return true;
        }
    }
}

?>