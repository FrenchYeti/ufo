<?php
namespace Ufo\Session;

use Ufo\Db\Manager as DbManager;
use Ufo\User\UserManager;
use Ufo\Error\StandardException as StandardException;

/**
 * Parent Exception Class
 */
class SessionException extends StandardException
{
    public function __construct( $calledmethod_str = '', $message_str = '', $code = StandardException::STANDARD_LVL)
    {
        //var_dump(get_class($this),__NAMESPACE__,substr(get_class($this),strlen(__NAMESPACE__)+1));
        //var_dump(SessionListener::getInstance()->_listener[]());
        //SessionListener::event(substr(get_class($this),strlen(__NAMESPACE__)+1));
        
        parent::__construct('Ufo\Session\Session',' 
            -- On : <i>'.$calledmethod_str.'</i> <br>
            -- Exception caught : <i>'.get_class($this).'</i> <br>
            -- Message : <i>'.$message_str.'</i><br>
            -- File: '.$this->getFile().' at line : '.$this->getLine().'<br>    
        	-- Trace: <pre>'.$this->getTraceAsString().'</pre>
        ',$code);
    }
}


/**
 * Child Exception Classes
 */
class SessionNotFoundException extends SessionException {}	//Use of sessions before setting them.
class NullUserException extends SessionException {}		//Null User passed.
class SessionExpired extends SessionException {}		//Session has Expired.
class DataIntegrityException extends SessionException {}
class DataNotExistsException extends SessionException {}


/**
 * 
 * @author gb-michel
 *
 */
class Session
{

	/**
	 * 
	 * @var Profile Session profile
	 */
	private $_profile = null;
	
	/**
	 * @var Token Session token to increase security around session fixation
	 */
	private $_token = null;
	
	/**
	 * @var array Cache of data stored in session
	 */
	private $_data_cache = array();
	
	/**
	 * The session ID.
	 * @var string
	 */
	protected $session = null;

	public $session_name = null;
	protected $session_name_hash = null;

	/**
	 * The user ID.
	 * @var string
	 */
	protected $userID = null;


	
	/**
	 * Idle period. If the user is inactive for more than this period, the session must expire.
	 * @var int
	 */
	public static $inactivityMaxTime = 1800; //30 min.

	

	/**
	 * Session Aging. After this period, the session must expire no matter what.
	 * @var int
	 */
	public static $expireMaxTime = 604800; //1 week.

	/**
	 * sweep ratio for probablity function in expired session removal process
	 * @var decimal
	 */
	public static $SweepRatio = 0.75; 
	
	
	public function __construct( $profile_str = NULL)
	{
		if($profile_str !== NULL)
		{
			$profile = new Profile($profile_str);			
			self::$expireMaxTime = $profile->get('SESSION_EXPIRE');
		}
	}
	
	/**
	*	When object is serialized, cache is flush
	* 	because all data are already stored in database
	*
	*/
	public function __sleep()
	{
		unset($this->_data_cache);
		
		return array('_profile','_token','session','userID','session_name','session_name_hash');
	}
        
	/**
	 *  Function to sweep expired session from db
	 */ 
	private function clearExpiredSession( $force = false )
	{
		if (!$force) if (rand ( 0, 1000 ) / 1000.0 > self::$SweepRatio) return;
      
		$timeLimit = \Ufo\Core\Init\time() - self::$inactivityMaxTime;
		$db = DbManager::getConnexion('internals/users_manager');

		/*
		 * query to delete expired session from both SESSION and SESSION_DATA table
		 */
		$result = $db->SQL('SELECT `SESSION_ID` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` WHERE `SES_LAST_ACTIVITY` < ?',array($timeLimit));
		foreach($result as $id)
		{
			$db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_DATA_SSD').'` WHERE `SESSION_ID` = ?',array($id['SESSION_ID']));
			$db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` WHERE `SESSION_ID` = ?',array($id['SESSION_ID']));
		}
	}
	
	/**
	 * Function to check if sessionID is set for this user or not.
	 * @throws SessionNotFoundException
	 */
	private function checkIfSessionIDisSet()
	{
		if ( ($this->session == "") || ($this->session == null) )
		{
			throw new SessionNotFoundException('Session::checkIfSessionIDisSet()',"No session is set for this user.",StandardException::WARNING_LVL);
		}
	}
	
	
	
	/**
	 * To return the current session ID.
	 * @return string		The session ID
	 * @throws SessionExpired	Thrown when the session has expired
	 */
	public function getSessionID()
	{
		if ($this->inactivityTimeout() || $this->expireTimeout())
		{
			throw new SessionExpired('Session::getSessionID()',"This session has expired.",StandardException::NOTICE_LVL);
		}
		
		return $this->session;
	}


	
	/**
	 * To return the current User ID.
	 * @return string | NULL
	 */
	public function getUserID()
	{
		return $this->userID;
	}

	/**
	 * To create a new Session ID for the given user.
	 * @param string $userID	The id of the user
	 * @return string		The new session ID of the current user.
	 */
	public function newSession($userID, $updateuser_manager = false)
	{
		if ( ($userID == null) || ($userID == "") )
			throw new NullUserException('Session::newSession()',"UserID cannot be null.",StandardException::FATAL_LVL);
		
		$db = DbManager::getConnexion('internals/users_manager');

		$this->userID = $userID;
		$this->session = \Ufo\Core\Init\randstr(128); //generate a new random string for the session ID of length 32.
		
		$time = \Ufo\Core\Init\time(); //get the current time.
		$db->SQL('INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` (`SESSION_ID`, `SES_DATE_CREATED`, `SES_LAST_ACTIVITY`, `USR_ID`) VALUES (?, ?, ?, ?)', array($this->session, $time, $time, $this->userID));
		
		$this->updateUserCookies();
		
		
		/**
		 * Function to clear expired sessions
		 */
		$this->clearExpiredSession();
		
		if( $updateuser_manager == true){
		    UserManager::getInstance()->setCurrentSession($this);
		}

		return $this->session;
	}
	
	
	
	/**
	 * Function to get the session object from an old sessionID that we receive from the user's cookie.
	 * @return string | FALSE	Returns the sessionID or FALSE
	 * @throws SessionExpired	Thrown when the session has expired
	 */
	public function existingSession( $session_name_str = 'default_session')
	{
		if( $session_name_str !== null){
			if( $this->session_name_hash == null){
				$cookie_name = hash('sha256',$session_name_str._UFO_SEC_STATIC_SALT_);
			}else{
				$cookie_name = $this->session_name_hash;
			}
		}
		else{
			$cookie_name = 'SESSIONID';
		}
		
		
		if (!isset($_COOKIE[$cookie_name]))	//If user cannot provide a session ID, then no session is present for this user. Hance return false
			return FALSE;
			
		
		$sessionID = $_COOKIE[$cookie_name]->sanitizeWithCheck('pureText',true,false,128);	//get the session ID from the user cookie
		$db = DbManager::getConnexion('internals/users_manager');

		$result = $db->SQL('SELECT `USR_ID` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` WHERE `SESSION_ID` = ?', array($sessionID));	//match if the session ID received from the user is same as what was issued to them. If same, then the session ID stored in our DB must match with the one we received
		if (count($result) != 1)	//a suitable match is not found
		{
			$this->updateUserCookies(TRUE);		//delete the cookie from user's browser
			return FALSE;
		}
		
		//set local variables
		$this->session = $sessionID;
		$this->userID = $result[0]['USR_ID'];
		$this->session_name = $session_name_str;
		$this->session_name_hash = ($cookie_name !== 'SESSIONID')? $cookie_name : null;
		
		//check if the session ID's have expired
		if ($this->inactivityTimeout() || $this->expireTimeout())
		{
			throw new SessionExpired('Session::existingSession()',"This session has expired.",StandardException::NOTICE_LVL);
		}
		
		$this->updateLastActivity();
				
		return $this->session;
	}
	
	
	
	/**
	 * Function to update/delete user session cookies
	 * @param boolean $deleteCookie		True indicates this function to DELETE the cookie from the user's browser. False indicates this function to CREATE the cookie in user's browser.
	 */
	public function updateUserCookies($deleteCookie = FALSE)
	{
		if ($deleteCookie === FALSE)
		{
			if( $this->session_name !== null){
				\setcookie($this->session_name_hash, $this->session, \Ufo\Core\Init\time() + Session::$expireMaxTime, null, null, FALSE, TRUE);
			}
			else{
				\setcookie("SESSIONID", $this->session, \Ufo\Core\Init\time() + Session::$expireMaxTime, null, null, FALSE, TRUE);
			}
		}
		else
		{
			if( $this->session_name !== null){
				\setcookie($this->session_name_hash, NULL, \Ufo\Core\Init\time() - Session::$expireMaxTime, null, null, FALSE, TRUE);
			}
			else{
				\setcookie("SESSIONID", NULL, \Ufo\Core\Init\time() - Session::$expireMaxTime, null, null, FALSE, TRUE);
			}	
		}
	}

	

	/**
	 * To get all session IDs for the user. Total count of session is also the indication of how many devices the user is currently logged in from because each valid session refers to one device.
	 * @param string $userID	User-ID of the user
	 * @return string[] | FALSE	Array containing all the session ID's of that user or FALSE in case no record is found
	 */
	public static function getAllSessions($userID)
	{
		$db = DbManager::getConnexion('internals/users_manager');
		$result = $db->SQL('SELECT `SESSION_ID` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` WHERE USR_ID = ?', array($userID));
		
		if (count($result) != 0)
		{
			return $result;
		}
		
		return FALSE;
	}

	

	/**
	 * To store data in current session.
	 * @param string $key			The 'name' of the data. The actual data will be referenced by this name.
	 * @param string $value			The actual data that needs to be stored
	 * @throws SessionNotFoundException	Thrown when trying to store data when no session ID is set
	 * @throws SessionExpired		Thrown when the session has expired
	 */
	public function setData($key, $value)
	{
	    try{
    		$this->checkIfSessionIDisSet();
    
    		//check before setting data, if the session has expired.
    		if ($this->inactivityTimeout() || $this->expireTimeout()) {
    			throw new SessionExpired('Session::setData()',"This session has expired.",StandardException::FATAL_LVL);
    		}
    
		$db = DbManager::getConnexion('internals/users_manager');

    		//check if the key given by the user has already been set. If yes, then the value needs to be replaced and new record for key=>value is NOT needed.
    		if (count($this->getData($key)) == 1)
    		{
    			$f = $db->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_DATA_SSD').'` SET `SSD_VALUE` = ? WHERE `SSD_KEY` = ? AND SESSION_ID = ?', array($value, $key, $this->session));
    			if( $f !== false){
    			    $this->_data_cache[$key] = $value;
    			}
    		} 
    		else //If the key is not found, then a new record of key=>value pair needs to be created.
    		{
    			$f = $db->SQL('INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_DATA_SSD').'` (`SESSION_ID`, `SSD_KEY`, `SSD_VALUE`) VALUES (?, ?, ?)', array($this->session, $key, $value));  
                if( $f !== false){
                    $this->_data_cache[$key] = $value;
                }    	
                else{
                    
                }	      
    		}
	    }
	    catch( SessionNotFoundException $e){
	        header('Location: '._UFO_DEFAULT_DOCUMENT_ERROR_);
	    }
	    catch( SessionExpired $e){
	        header('Location: '._UFO_DEFAULT_DOCUMENT_ERROR_);
	    }
	}

	
	

	
	/**
	 * To retrieve data from current session
	 * @param string $key			The name of the data from which it is referenced
	 * @return string[]			The key=>value pair. Empty array will be returned in case no data is found
	 * @throws SessionNotFoundException	Thrown when trying to retrive data when sessionID is not set
	 * @throws SessionExpired		Thrown when the session has expired
	 */
	public function getData($key)
	{
		$this->checkIfSessionIDisSet();
		
		//check before retrieving data, if the session has expired.
		if ($this->inactivityTimeout() || $this->expireTimeout()) {
			throw new SessionExpired('Session::getData()',"This session has expired.",StandardException::FATAL_LVL);
		}

		$this->updateLastActivity();
		$db = DbManager::getConnexion('internals/users_manager');

		$result = $db->SQL('SELECT `SSD_KEY`, `SSD_VALUE` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_DATA_SSD').'` WHERE `SESSION_ID` = ? and `SSD_KEY` = ?', array($this->session, $key));
		
		if( isset($result[0]))
		    return $result[0]['SSD_VALUE'];
		else 
		    return null;
	}


	
	/**
	 * To check if inactivity time has passed for this session.
	 * @return boolean	Returns True if inactivity time has passed. False otherwise
	 */
	public function inactivityTimeout()
	{
		if ( ($this->session == null) || ($this->session == "") )
			return TRUE;

		$db = DbManager::getConnexion('internals/users_manager');
		$result = $db->SQL('SELECT `SES_LAST_ACTIVITY` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` WHERE `SESSION_ID` = ?', array($this->session));
		
		if (count($result) == 1)
		{
			$lastActivityTime = (int)$result[0]['SES_LAST_ACTIVITY']; //get the last time when the user was active.

			$difference = \Ufo\Core\Init\time() - $lastActivityTime; //get difference betwen the current time and the last active time.

			if ($difference > Session::$inactivityMaxTime) //if difference exceeds the inactivity time, destroy the session.
			{
				$this->destroySession();
				return TRUE;
			}
			
			return FALSE;
		}
		else
		{
			$this->session = NULL;
			return TRUE;
		}
	}


	
	/**
	 * To check if expiry time has passed for this session.
	 * @return boolean	Returns True if the expiry time has passed for this user. False otherwise
	 */
	public function expireTimeout()
	{
		if ( ($this->session == null) || ($this->session == "") )
			return TRUE;

		$db = DbManager::getConnexion('internals/users_manager');
		$result = $db->SQL('SELECT `SES_DATE_CREATED` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` WHERE `SESSION_ID` = ?', array($this->session));
		
		if (count($result) == 1)
		{
			$lastActivityTime = (int)$result[0]['SES_DATE_CREATED']; //get the date when this session was created.

			$difference = \Ufo\Core\Init\time() - $lastActivityTime; //get difference betwen the current time and the creation time.

			if ($difference > Session::$expireMaxTime) //if difference exceeds the expiry time, destroy the session.
			{
				$this->destroySession();
				return TRUE;
			}

			return FALSE;
		}
		else
		{
			$this->session = NULL;
			return TRUE;
		}
	}


	
	/**
	 * To refresh the session ID of the current session. This will update the last time that the user was active and the session creation date to the current time. The essence is to make the session ID look like it was just created now.
	 * @return string			Returns the new/current sessionID and update the browser's cookies
	 * @throws SessionNotFoundException	Thrown when trying to refresh session when no session ID is set
	 * @throws SessionExpired		Thrown when the session has expired
	 */
	public function refreshSession()
	{
		$this->checkIfSessionIDisSet();

		//check for session expiry.
		if ($this->inactivityTimeout() || $this->expireTimeout()) {
			throw new SessionExpired('Session::refreshSession()',"This session has expired.",StandardException::FATAL_LVL);
		}
		
		$db = DbManager::getConnexion('internals/users_manager');

		//exchange the old session's creation date and the last activity time with the current time.
		$db->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` SET `SES_DATE_CREATED` = ? , `SES_LAST_ACTIVITY` = ? WHERE SESSION_ID = ?', array(time(), time(), $this->session));
		$this->updateUserCookies();
		return $this->session;
	}

	

	/**
	 * To destroy the current Session.
	 * @throws SessionNotFoundException	Thrown when trying to destroy a session when one does not exists
	 */
	public function destroySession()
	{
		$this->checkIfSessionIDisSet();

		$db = DbManager::getConnexion('internals/users_manager');

		$db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_DATA_SSD').'` WHERE `SESSION_ID` = ?', array($this->session)); //delete all data associated with this session ID.
		$db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` WHERE `SESSION_ID` = ?', array($this->session)); //delete this sessiom ID.

		$this->session = null;
		$this->updateUserCookies(TRUE);
	}

	

	/**
	 * To destroy all the sessions associated with the current User.
	 */
	public static function destroyAllSessions($userID)
	{
		$allSessions = Session::getAllSessions($userID); //get all sessions associated with this user.

		$db = DbManager::getConnexion('internals/users_manager');
		foreach ($allSessions as $args)		// For each of those sessions, delete data stored by those sessions and then delete the session IDs.
		{
			$db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_DATA_SSD').'` WHERE `SESSION_ID` = ?', array($args['SESSION_ID']));
			$db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` WHERE `SESSION_ID` = ?', array($args['SESSION_ID']));
		}
	}

	

	/**
	 * To promote/demote a session. This essentially destroys the current session ID and issues a new session ID.
	 * @return string			Returns the new sessionID and updates user cookies
	 * @throws SessionNotFoundException	Thrown when trying to roll a session when sessionID is not set
	 * @throws SessionExpired		Thrown when the session has expired
	 */
	public function rollSession()
	{
		$this->checkIfSessionIDisSet();

		//check for session expiry.
		if ($this->inactivityTimeout() || $this->expireTimeout()) {
			throw new SessionExpired('Session::rollSession()',"This session has expired.",StandardException::FATAL_LVL);
		}

		$db = DbManager::getConnexion('internals/users_manager');

		//get all the data that is stored by this session.
		$result = $db->SQL('SELECT `SSD_KEY`, `SSD_VALUE` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_DATA_SSD').'` WHERE SESSION_ID = ?', array($this->session));

		//destroy the current session.
		$this->destroySession();

		//create a new session.
		$newSession = $this->newSession($this->userID);

		//copy all the previous data to this new session.
		foreach ($result as $arg) {
			$this->setData($arg['SSD_KEY'], $arg['SSD_VALUE']);
		}
		
		$this->updateUserCookies();
		return $newSession;
	}
	
	
	
	/**
	 * Functoin to get the userID from a sessionID
	 * @param string $sessionID	The session ID for which matching userID is needed
	 * @return boolean | string	Returns the userID if match found. False otherwise
	 */
	public static function getUserIDFromSessionID($sessionID)
	{
		$db = DbManager::getConnexion('internals/users_manager');

		$result = $db->SQL('SELECT `USR_ID` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` WHERE `SESSION_ID` = ?', array($sessionID));
		
		if (count($result) == 1)
		{
			return $result[0]['USR_ID'];
		}
		else
			return FALSE;
	}
	
	
	/**
	 * Function to update SESSION_ID LastActivity
	 * @throws SessionNotFoundException	Thrown when trying to store data when no session ID is set
	 * @throws SessionExpired		Thrown when the session has expired
	 */
	public function updateLastActivity()
	{ 
		$this->checkIfSessionIDisSet();

		//check for session expiry.
		if ($this->inactivityTimeout() || $this->expireTimeout())
			throw new SessionExpired('Session::updateLastActivity()',"This session has expired.");
		
		$db = DbManager::getConnexion('internals/users_manager');
		$db->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_SES').'` SET `SES_LAST_ACTIVITY` = ? WHERE `SESSION_ID` = ?',array(\Ufo\Core\Init\time(), $this->session));
	}


	public function setSessionName( $name_str)
	{
		$this->session_name = $name_str;
		$this->session_name_hash = hash('sha256',$name_str._UFO_SEC_STATIC_SALT_);	
	}
	
	/**
	 * To store safely serialized object in current session.
	 * Each object is signed
	 *
	 * @param string $key			The 'name' of the data. The actual data will be referenced by this name.
	 * @param string $value			The actual data that needs to be stored
	 * @throws SessionNotFoundException	Thrown when trying to store data when no session ID is set
	 * @throws SessionExpired		Thrown when the session has expired
	 * @author GBMichel
	 */
	public function setDataObject($key, $value)
	{
	    $serial = serialize($value);
	    $this->setData($key, $serial);
	    $this->setData($key.'_sum', sha1($serial));
	}
	
	/**
	 * To retrieve serialized object from current session,
	 * and check signature
	 *
	 * @param string $key			The name of the data from which it is referenced
	 * @return string[]			The key=>value pair. Empty array will be returned in case no data is found
	 * @throws SessionNotFoundException	Thrown when trying to retrive data when sessionID is not set
	 * @throws SessionExpired		Thrown when the session has expired
	 * @author GBMichel
	 */
	public function getDataObject($key,$default = null)
	{
	    $sum = $this->getData($key.'_sum');	    
	    if( $sum !== null){
	        $obj = $this->getData($key);

	        // Check integrity of serialized object
	        if($sum == sha1($obj)){
	            return unserialize($obj);
	        }
	        else{
	            throw new DataIntegrityException('Session::getDataObject()',"Stored object is corrupted");
	            return null;
	        }
	    }
	    else{
	        if( $default !== null){
	            return $default;
	        }
	        else{
	           throw new DataNotExistsException('Session::getDataObject()','Session data "'.$key.'" not found',StandardException::NOTICE_LVL);
	           return null;
	        }
	    }
	}
	
	/**
	 * To check if an object is stored in session
	 * 
	 * @param string $key Name associate to the data
	 * @return boolean Return TRUE if data exist, else FALSE
	 * @author GBMichel
	 */
	public function issetDataObject($key)
	{
	    $sum = $this->getData($key.'_sum');
	    return (count($sum)>0)? true : false;
	}
	
	/**
	 * To remove data objects stored in session
	 *
	 * @param string $key Name associate to the data
	 * @author GBMichel
	 */
	public function removeDataObject($key)
	{
	    if($this->issetDataObject($key)){
	        $db = DbManager::getConnexion('internals/users_manager');
	        $db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_SESSION_DATA_SSD').'`
		        WHERE `SESSION_ID` = ?
		        AND ((`SSD_KEY` = ?) OR (`SSD_KEY` = ?))',array($this->session,$key,$key.'_sum'));
	    }
	}
	
	/**
	 * SessionNotFound listener
	 *
	 * @param unknown $function
	 */
	/*
	public static function onSessionNotFound( $function)
	{
	    $this->_listener['sessionnotfound'] = $function;
	}
	
	public static function onSessionExpired( $function)
	{
	    $this->_listener['sessionexpired'] = $function;
	}
	
	public static function onGetSessionFailed( $function)
	{
	    $this->_listener['getsessionfailed'] = $function;
	}
	 */   
	
	/**
	 * Create a new Token object and generate value,
	 * if _USE_DOUBLE_TOKEN_ is TRUE in config, name of token is 
	 * randomized.
	 * 
	 * Token is serialized and stored in session, SHA checksum of serial 
	 * is stored in session.
	 * 
	 * @method void Cree ou modifie le token
	 * @author GB Michel
	 * @version 1.0
	 * @since 12/04/2013
	 */
	private function newToken()
	{	
		// Creation des donnees du token
		if( $this->_profile->get('USE_DOUBLE_TOKEN') == true ){			
			$this->_token['name'] = md5(\Ufo\Core\Init\rand(20,100)).'#'.sha1(\Ufo\Core\Init\time());
		}
		else{
			$this->_token['name'] = $this->_profile->get('TOKEN_NAME') ;
		}		
		$this->_token['value'] = sha1(time().rand(0,100).$this->_profile->get('TOKEN_GDS')) ;

		// Store token in current session
		$this->setData('token', $this->_token);
			
		// Envoie du token
		\setcookie( $this->_token['name'], $this->_token['value'], 
		  time()+intval($this->_profile->get('SESSION_EXPIRE')), 
		  $this->_profile->get('SESSION_PATH'),TRUE,TRUE
        );
	}
	
	
	/**
	 * 
	 */
	private function checkTokenValidity()
	{
	    
	}
	
	
	/**
	 * 
	 */
	private function destroyToken()
	{
	    \setcookie( $this->_token['name'], "");
	}
	
}

?>
