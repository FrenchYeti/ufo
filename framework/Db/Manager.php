<?php

namespace Ufo\Db;

use Ufo\Error\DbException as DbException;

/**
 *
 * @author gb-michel
 *
 */
class ManagerException extends DbException
{
    public function __construct( $calledmethod_str = '', $message_str = '', $code = DbException::STANDARD_LVL)
    {
        parent::__construct('Ufo\Db\Manager',' 
            -- On : <i>'.$calledmethod_str.'</i> <br>
            -- Exception caught : <i>'.get_class($this).'</i> <br>
            -- Message : <i>'.$message_str.'</i><br>
            -- File : '.$this->getFile().' at line :'.$this->getLine().'<br>
            -- Trace : '.$this->getTraceAsString().'<br>    
        ',$code);
    }
}


class Manager
{
    private static $_instance=null;
    
    private $_default_profile = null;
    private $_profiles_loaded = array();
    private $_profiles = array();
    private $_connexion = array();
    
    /**
     * 
     */
    private function __construct(){}
    
    
    /**
     * 
     * @return \Ufo\Db\Manager
     * @version 2.0
     * @since 17/12/2013
     * @author GBMichel
     */
    public static function getInstance()
    {
        if(is_null(self::$_instance)){
           self::$_instance = new Manager(); 
        }
        
        return self::$_instance;
    }
    
    
    /**
     * 
     * @param unknown $profilename_str
     * @version 2.0
     * @since 17/12/2013
     * @author GBMichel
     */
    public function issetConnexion($profilename_str)
    {
        return isset($this->_profiles[$profilename_str]);    
    }
    
    
    
    /**
     * Return a Db\Connexion object instanciate with corresponding Profile  
     * 
     * @param unknown $profilename_str
     * @return \Ufo\Db\Connexion
     * @version 2.0
     * @since 17/12/2013
     * @author GBMichel
     */
    public static function getConnexion($profilename_str = null)
    {
    	$o = self::getInstance();
    	

    	if( is_null($profilename_str) && !is_null($o->_default_profile)){
    	    $profilename_str = $o->_default_profile;
    	}
    	
        if(!in_array($profilename_str,$o->_profiles_loaded)){
            
            try{
                $o->_profiles[$profilename_str] = new Profile($profilename_str);
            }
            catch( ProfileException $e){
                throw new ManagerException('Manager::getConnexion()','Failed to load profile :'.$profilename_str,DbException::FATAL_LVL);
            }
            
            if( $o->_profiles[$profilename_str]->isLoaded()){
                $o->_profiles_loaded[] = $profilename_str;
            }            
        }
        
        // Create connexion if not exists
        if(!in_array($profilename_str,$o->_connexion)){
            
            try{
                $o->_connexion[$profilename_str] = new Connexion($o->_profiles[$profilename_str]);
            }
            catch( ConnexionException $e){
                throw new ManagerException('Manager::getConnexion()','Failed to mount connexion to Db width profile :'.$profilename_str,DbException::FATAL_LVL);
                return null;
            }
            
            return $o->_connexion[$profilename_str];
        }
        else{
            return $o->_connexion[$profilename_str];
        }
    }
    
    
    /**
     * 
     * @param unknown $profilename_str
     * @version 2.0
     * @since 17/12/2013
     * @author GBMichel
     */
    public function getProfile($profilename_str)
    {
        if( $this->issetConnexion($profilename_str)){
            return $this->_profiles[$profilename_str];
        }
        else{
            return null;
        }
    }
    
    /**
     * 
     * 
     * @param unknown $profilename_str
     * @throws Exception\ManagerException
     */
    public function setDefaultProfile($profilename_str)
    {
        $this->_default_profile = $profilename_str;
    }
}

/**
 * A global function for namespace "Ufo"
 * Function to make a SQL query. The query must be in parameterized form. E.g. SQL("SELECT * FROM USER WHERE USERID = ?", $userID); The second argument defines the string that must substitute the question mark given in the query.
 * @param  array		Array containing query and arguments to this function call
 * @return array		Array containg the result of the operation
 * @throws ManagerException	Thrown when trying to manipulate DB when a connection does not exists
 */
function SQL()
{
	$db = Manager::getConnexion(_UFO_SECURITY_DB_PROFILE_);

	if ($db == NULL) {
		throw new ManagerException('SQL()',"Database is not set/configured properly.",DbException::FATAL_LVL);
	}

	$args = func_get_args();	//get the arguments supplied to this function
	$query = array_shift($args);	//Take the first argument as that is the QUERY to the DB

	if (count($args) == 0) {	//If there are no arguments left, then run the query without any arguments i.e. pass an empty array as the argument. Such as "SELECT * FROM USER"
		return $db->SQL($query, array());
	}

	if (is_array($args[0])) {	//If the remaining argument is itself an array, then pass that array as the argument
		return $db->SQL($query, $args[0]);
	} else {	//Else just pass the remaining arguments
		return $db->SQL($query, $args);
	}
}
?>