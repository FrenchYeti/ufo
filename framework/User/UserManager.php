<?php

namespace Ufo\User;

use Ufo\Session\Session as Session;
use Ufo\Session\SessionManager as SessionManager;
use Ufo\Error\StandardException;
use Ufo\Core\ObjectManager as ObjectManager;
use Ufo\Core\ObjectManagerInterface as ObjectManagerInterface;


class UserManagerException extends \Ufo\Error\StandardException 
{
    public function __construct( $calledmethod_str = '', $message_str = '', $code = 2, $previous = null)
    {
    	if( $previous !== null)
    		$prev = '<span style="color:#F00;">Previous exception catched : '.get_class($previous).'</span><br>';
    	else 
    		$prev = '';
    	
        parent::__construct('Ufo\User\UserManager',$prev.' 
            -- On : <i>'.$calledmethod_str.'</i> <br>
            -- Exception caught : <i>'.get_class($this).'</i> <br>
            -- Message : <i>'.$message_str.'</i><br>
            -- File : '.$this->getFile().' at line : '.$this->getLine().'<br>
        	-- Trace : <pre>'.$this->getTraceAsString().'</pre>
        ',$code,$previous);
    }
}

class UserManagerDataNotFound extends UserManagerException {}
class UserManagerOpenException extends UserManagerException {}
class UserManagerSessionNotFound extends UserManagerException {} 

/**
 *
 * @author gb-michel
 *        
 */
class UserManager extends ObjectManager
{
	private static $_instance = null;
	
	private static $_open = FALSE;
	
    private $_dbprofile = null;
    
    public $data = array();
    
    private $_session_manager = null;
    
    
    
    public $errorInfo = null;
    public $errorCode = 0;
    
    
    public function __sleep()
    {
    	return array('managed','data');	
    }
    
    
    public static function getInstance()
    {
    	if( self::$_instance == null){
    		self::$_instance = new UserManager();
    	}	
    	
    	return self::$_instance;
    }
    
    /**
     * To save UserManager in her session
     * 
     * 
     */
    private static function saveState()
    {
    	$self = self::getInstance();
    	
    	// store UserManager into user session
    	SessionManager::getSession('user_session')->setDataObject('user_manager',$self);
    	
    	// store SessionManager into user session
    	SessionManager::storeIn('user_session');
    }
    
    /**
     * Set current user, managed by user manager
     */
    private static function setUser( User $usr_obj)
    {
    	$self = self::getInstance();
    	try{
    		$self->attach('user', $usr_obj);
    		$self->data['dbprofile'] = $self->get('user')->getRole()->getDbProfileName();
    
    		// set the default profile of db's user in Db Manager
    		\Ufo\Db\Manager::getInstance()->setDefaultProfile($self->data['dbprofile']);
    	}
    	catch( \Ufo\User\UserRoleNotExistsException $rne){
    		$self->errorInfo = 'Role not exists for this user';
    		$self->errorCode = 0x00000001;
    		throw new UserManagerException('UserManager::setCurrentUser()',$self->errorInfo,$self->errorCode,$rne);
    	}
    	catch( \Ufo\Error\CorruptedDataException $cde){
    		$self->errorInfo = 'Role cannot be imported, data are corrupted';
    		$self->errorCode = 0x00000002;
    		throw new UserManagerException('UserManager::setCurrentUser()',$self->errorInfo,$self->errorCode,$cde);
    	}
    	catch( \ErrorException $e){
    		$self->errorInfo = 'Internals PHP errors occur';
    		$self->errorCode = 0x00000003;
    		throw new UserManagerException('UserManager::setCurrentUser()',$self->errorCode,$self->errorCode,$e);
    	}
    }
    
	/**
	 * To check if UserManager is open
	 * 
	 * Check if UserManager is already open.
	 * If UserManager is started in previous script, 
	 * but not open in current script, this method return FALSE
	 * 
	 * @static
	 * @method boolean isOpen()
	 * @return boolean Return TRUE if UserManager is already open, else FALSE 
	 * @version 0.9
	 * @since 05/02/2014
	 */
    public static function isOpen()
    {
    	return self::$_open;
    }
    
	/**
	 * To get the name of DB Profile of the current user
	 * 
	 * Return the name of DB profile of current user
	 * 
	 * @static 
	 * @method string getDBProfile()
	 * @return string DB Profile the name of DB Profile of current user
	 * @version 0.9
	 * @since 15/02/2014 
	 */    
    public static function getDBProfile()
    {
    	return self::getInstance()->data['dbprofile'];
    }
    
    
    /**
     * To get the UserProxy of User managed by the UserManager
     * 
     * @static
     * @method UserProxy getUser()  
     * @return UserProxy 
     */
    public static function getUser()
    {
    	return self::getInstance()->get('user');
    }

    
    /**
     * To get SessionProxy of the current session
     * 
     * @static
     * @method SessionProcy|NULL getSession()
     * @return SessionProxy|NULL Return SessionProxy of the current session, else if session not exists NULL
     */
    public static function getSession()
    {
    	return SessionManager::getSession('user_session',false);
    }
    
    /**
     * To check 
     * 
     * @param unknown $operationname_str
     * @throws UserManagerException
     * @return boolean
     */
    public static function checkAuthorization( $operationname_str = null)
    {
    	if( self::isOpen()){
    		return self::getUser()->getRole()->isAuthorized($operationname_str);
    	}
    	else{
    		return false;
    	}
    } 
    
    
    public function setData($key_str, $value_mixed)
    {
        self::setUserData($key_str,$value_mixed);
        
        return self::$_instance;
    }
    
    
    /**
     * To store data in UserManager session
     */
    public static function setUserData( $key_str, $value_mixed )
    {
    	// store data
    	if( is_object($value_mixed))
    		self::attach($key_str,$value_mixed);
        else
            self::getInstance()->data[$key_str] = $value_mixed;
        
        // save UserManager
        self::saveState();
    }
    
    public function getData($key_str,$is_object = false)
    {
        self::getUserData($key_str,$is_object);
    
        return self::$_instance;
    }
    
    /**
	 * To get data from UserManager session
	 * 
	 * 
     */
    public static function getUserData($key_str,$is_object = false)
    {
    	if( $is_object == true){
    		return self::get($key_str);
    	}
    	else{
    		$self = self::getInstance();
    		if( isset($self->data[$key_str])){
    			return $self->data[$key_str];
    		} 
    		else{
    		    throw new UserManagerDataNotFound('getUserData()','Data not found in UserManager');
    		}
    	}
    }
    
    
    /**
     * UserManager persistance is based on session =>
     * Only SessionManager is authorized to manage session => 
     * UserManager depends of SessionManager
     * 
     * UserManager offers an enriched session
     *   
     * @param User $usr_obj
     */
    public static function start( User $usr_obj)
    {
    	try{
	    	$self = self::getInstance();
	    	
	    	// attach USER to Manager
	    	self::setUser($usr_obj);
	    	
	    	// create new session 
	    	SessionManager::newSession( $self->get('user')->getUserID(), 'user_session');
    	
    		// store UserManager into her session
    		self::saveState();
    		
    		self::$_open = TRUE;

    		return true;
    	}
    	catch( UserManagerException $e){
    		
    		return false;
    	}
    }
    
    
    /**
     * To open the started UserManager
     *  
     * @throws UserManagerOpenException
     */
    public static function open()
    {
    	if( self::$_open === FALSE){

    		try{
	    		// restore SessionManager	
	    		SessionManager::importFrom('user_session');
	    		
	    		// restore UserManager
	    		self::$_instance = SessionManager::getSession('user_session')->getDataObject('user_manager');
	    		
	    		// set default db profile in db manager
	    		\Ufo\Db\Manager::getInstance()->setDefaultProfile(self::getDBProfile());
	    		
	    		self::$_open = TRUE;
    		}
    		catch( \Ufo\Session\SessionSupportNotFound $e){
    			throw new UserManagerOpenException('UserManager::open()','Import of SessionManager failed. Session not found.',StandardException::FATAL_LVL, $e);
    		}
    		catch( \Ufo\Session\SessionManagerNotImported $e){
    			throw new UserManagerOpenException('UserManager::open()','Import of SessionManager failed. Session not found.',StandardException::FATAL_LVL, $e);
    		}
    		catch( \Ufo\Session\SessionNotFoundException $e){
    			throw new UserManagerOpenException('UserManager::open()','UserManager opening failed. Session not found.',StandardException::FATAL_LVL, $e);
    		}
    		catch( \Ufo\Session\DataNotExistsException $e){
    			throw new UserManagerOpenException('UserManager::open()','UserManager opening failed. UserManager not stored in session.',StandardException::FATAL_LVL, $e);
    		}
    		catch( \Ufo\Session\DataIntegrityException $e){
    			throw new UserManagerOpenException('UserManager::open()','UserManager opening failed. UserManager stored in session is corrupted.',StandardException::FATAL_LVL, $e);
    		}
    	}	
    }
    
    /**
     * To close the opened UserManager
     */
    public static function close()
    {
    	if( self::$_open === TRUE){
    		try{
    			$self = self::getInstance();
    			
    			// destruct support session of UserManager
    			SessionManager::destroySession('user_session');
    			
    			// destroy managed object
    			foreach( $self->managed as $k=>$o){
    				$self->detach($k);
    			}
    			
    			// destroy instance
    			self::$_instance = null;
    		}
    		catch( UserManagerException $e){}
    	}
    }
}

?>