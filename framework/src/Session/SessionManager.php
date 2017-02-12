<?php 
/**
 * 
 * @author gb-michel
 *
 */

namespace Ufo\Session;

use Ufo\Error\StandardException as StandardException ;
use Ufo\Core\ObjectManager as ObjectManager;
use Ufo\Core\ObjectManagerInterface as ObjectManagerInterface;


/**
*
*
*/
class SessionManagerException extends StandardException 
{
	public function __construct( $calledmethod_str = '', $message_str = '', $code = StandardException::STANDARD_LVL, $previous = null)
    {
    	if( $previous !== null)
    		$prev = '<span style="color:#F00;">Previous exception catched : '.get_class($previous).'</span><br>';
    	else
    		$prev = '';
    	 
        parent::__construct('Ufo\Session\SessionManager',$prev.' 
            -- On : <i>'.$calledmethod_str.'</i> <br>
            -- Exception caught : <i>'.get_class($this).'</i> <br>
            -- Message : <i>'.$message_str.'</i><br>
            -- File: '.$this->getFile().' at line : '.$this->getLine().'<br>   
        	-- Trace: <pre>'.$this->getTraceAsString().'</pre>	 
        ',$code,$previous);
    }
}


class InvalidSessionNameException extends SessionManagerException {}
class SessionManagerNotImported extends SessionManagerException {}
class SessionSupportNotFound extends SessionManagerException {}
class SessionManagerNotStored extends SessionManagerException {}
class SessionNotManaged extends SessionManagerException {}

/**
*
*
*/
class SessionManager extends ObjectManager
{	
	private static $_instance = null;
	
    /**
     * 
     * @var unknown
     */
    private $_openedSession = array();
	private static $_restored = null;
    
    //private function __construct(){}
    
    public static function getInstance()
    {
    	if( self::$_instance == null) 
    		self::$_instance = new SessionManager();
    	
    	return self::$_instance;
    }
	
	
	public function __sleep()
	{
		// $this->_openedSession = array();
		
		return array('managed');
	}

	
    private static function checkIfSessionIsManaged( $sessionName_str)
    {
    	$self = self::getInstance();
    	if( !isset($self->managed[$sessionName_str])){
    		throw new SessionNotManaged('SessionManager::checkIfSessionIsManaged()','Session "'.$sessionName_str.'" is not managed',StandardException::NOTICE_LVL);
    	}
    }
	
    /**
     * 
     * @param unknown $sessionName_str
     * @return \Ufo\Session\unknown|NULL
     */
    public static function isSessionOpened( $sessionName_str)
    {
        $self = self::getInstance();
        
        return isset($self->_openedSession[$sessionName_str])? TRUE : FALSE;
    }

    

	/**
	* Create new session
	*
	* @return SessionProxy Return the session freshly create
	*/
	public static function newSession( $userID, $sessionName_str = 'default_session')
    {
    	
		try{
			$self = self::getInstance();
			
			// attach new session to manager
			$self->attach($sessionName_str, new Session());
			
			// set session name
			$self->get($sessionName_str)->setSessionName($sessionName_str);
			
			// open new session
			$self->get($sessionName_str)->newSession($userID);
			
			// add session to the list of opened session
			$self->_openedSession[$sessionName_str] = TRUE;
			
			return $self->get($sessionName_str);
		}
		catch( NullUserException $e){
			throw new SessionManagerException(
					'SessionManager::newSession','Create session failed, user ID is invalid',
					SessionManagerException::STANDARD_LVL, $e
			);
		}
	}


	/**
	*
	*
	*/
	public static function destroySession( $sessionName_str = 'default_session')
    {
		$self = self::getInstance();
		if( !isset($self->managed[$sessionName_str])){
			throw new SessionNotManaged('SessionManager::destroySession()','Session cannot be destroyed, session not managed.',StandardException::STANDARD_LVL);
		}
	
		try{
			if( !isset($self->_openedSession[$sessionName_str])){
				self::getSession($sessionName_str);
			}

			$self->get($sessionName_str)->destroySession();
		}
		catch( \Exception $e){
			echo 'erreur de destruction';
		}
	}

		
	public function destroyAllSession( $onlyOpened = FALSE)
	{
		$managed = array();
		
		foreach( $this->managed as $sess_name=>$sess)
		{
			if($onlyOpened === TRUE){
				if( isset($this->_openedSession[$sess_name])){
					$sess->destroySession();
				}
				else{
					$managed[$sess_name] = $sess;
				}
			}
			else{
				$sess->destroySession();	
			}
		}
		
		if($onlyOpened === TRUE) $this->managed = $managed;
	}


	/**
	* To get session by session name
	* 
	* 
	*
	* @method SessionProxy getSession()
	* @return SessionProxy Return SessionProxy of the existing session, else if session not exists return NULL 
	*/
	public static function getSession( $sessionName_str = 'default_session', $openExistingSession_bool = TRUE)
	{
		$self = self::getInstance();

		self::checkIfSessionIsManaged($sessionName_str);
		
        if( self::isSessionOpened($sessionName_str)){
            return $self->get($sessionName_str);
        }
        elseif( $openExistingSession_bool === TRUE){
        	
                $self->attach($sessionName_str, new Session());
                $sessionID = $self->get($sessionName_str)->existingSession($sessionName_str);
                 
                if( $sessionID !== FALSE){
                     
                    $self->_openedSession[$sessionName_str] = TRUE;
                    return $self->get($sessionName_str);
                }
                else{
                    throw new SessionNotManaged(
		        			'SessionManager::getSession()','Open existing session fail',
		        			StandardException::WARNING_LVL
					);
                }
        }
        else{
        	throw new SessionNotManaged(
        			'SessionManager::getSession()','Session is not open and can\'t be open',
        			StandardException::WARNING_LVL
			);
        }
	}

	/**
	 * @static 
	 * @method void storeIn ( string $sessionName_str ) Store SessionManager into a session
	 * @param string $sessionName_str Name of session where SessioNManager will be stored
	 * 
	 */
	public static function storeIn( $sessionName_str = 'default_session')
	{
		
		try{
			$self = self::getInstance();
			
			self::checkIfSessionIsManaged($sessionName_str);
			
			$self->managed[$sessionName_str]->setDataObject('session_manager',$self);
		}
		catch( SessionNotFoundException $e){
			throw new SessionManagerNotStored(
					'SessionManager::storeIn()','SessionManager cannot be stored in session. Session "'.$sessionName_str.'" not found.',
					StandardException::FATAL_LVL, $e
			);
		}
		catch( SessionExpired $e){
			throw new SessionManagerNotStored(
					'SessionManager::storeIn()','SessionManager cannot be stored in session. Session "'.$sessionName_str.'" is expired',
					StandardException::FATAL_LVL, $e
			);
		}
	}
	
	/**
	 * 
	 * @param unknown $sessionName_str
	 */
	public static function importFrom( $sessionName_str = 'default_session')
	{
		if( self::$_restored != TRUE){
			try{
				$self = self::getInstance();
				
				if( self::isSessionOpened($sessionName_str)){
					self::$_instance = $self->managed[$sessionName_str]->getDataObject('session_manager');				
				}
				else{

					$session = new Session();
					$session->existingSession($sessionName_str);
					self::$_instance = $session->getDataObject('session_manager');
					
					if( !isset(self::$_instance->managed[$sessionName_str])){
						throw new SessionManagerNotImported('SessionManager::importFrom()','Import of SessionManager failed. Session not managed.',StandardException::FATAL_LVL);
						// la 
						// echo 'Session source non mamangee';
					}
				}
				
				self::$_restored = TRUE;
			}
			catch( SessionExpired $e){
				throw new SessionManagerNotImported(
						'SessionManager::importFrom()','Import of SessionManager failed. Session expired.',
						StandardException::FATAL_LVL, $e);
			}
			catch( SessionNotFoundException $e){
				throw new SessionSupportNotFound(
						'SessionManager::importFrom()','Import of SessionManager failed. Session not found.',
						StandardException::FATAL_LVL, $e);
			}
			catch( SessionNotManaged $e){
				throw new SessionManagerNotImported(
						'SessionManager::importFrom()','Import of SessionManager failed. Session not managed.',
						StandardException::FATAL_LVL, $e);
			}
			catch( DataNotExistsException $e){
				throw new SessionManagerNotImported(
						'SessionManager::importFrom()','Import of SessionManager failed. SessionManager not stored in session.',
						StandardException::FATAL_LVL, $e);
			}
			catch( DataIntegrityException $e){
				throw new SessionManagerNotImported(
						'SessionManager::importFrom()','Import of SessionManager failed. SessionManager stored in session is corrupted.',
						StandardException::FATAL_LVL, $e);
			}
		}	
	}
}

?>
