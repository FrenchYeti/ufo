<?php

namespace Ufo\Error;

class ErrorHandlerAlreadySetException extends \Exception {}
class ErrorHandlerNotSetException extends \Exception {}

/**
 *
 * @author gb-michel
 *        
 */
class ErrorHandler implements HandlerInterface 
{
    
	/**
	 * Holds the previous error_reporting state so that we can get back there
	 * @var integer
	 */
	static private $backupErrorReportingState=null;
	
	static protected $isShutdownRegistered=null;
	
	/**
	 * Sets the phpsec error handler as error handler
	 * @throws ErrorHandlerAlreadySetException
	 */
	static public function enable()
	{
		if (self::isActive())
			throw new ErrorHandlerAlreadySetException("This function shouldn't be called twice.");
		self::$backupErrorReportingState=error_reporting();
		set_error_handler(__NAMESPACE__."\\ErrorHandler::_errorToException");
	
		if (!self::$isShutdownRegistered)
		{
			//no matter how many times enable is called, add shutdown function once
			register_shutdown_function(__NAMESPACE__."\\ErrorHandler::_shutdown");
			self::$isShutdownRegistered=true;
		}
		error_reporting(0);
	}
	
	
	/**
	 * Unsets phpsec error handler, back to the previous one
	 * @throws ErrorHandlerNotSetException
	 */
	static public function disable()
	{
		if (!self::isActive())
			throw new ErrorHandlerNotSetException("This function should be callde after setErrorHandler.");
		error_reporting(self::$backupErrorReportingState);
		restore_error_handler ();
	}
	
	
	/**
	 * Tells whether or not error handler is active
	 * @return boolean
	 */
	static public function isActive()
	{
		return self::$backupErrorReportingState!==null;
	}
	
	/**
	 * This is registered as a shutdown function to catch fatal errors
	 * Do not call this directly.
	 */
	public static function _shutdown()
	{
		//if error handler is not enabled, just ignore
		if (!self::isActive()) return;
	
		$e=error_get_last();
		if ($e===null) return; //no errors yet!
		$type=$e['type'];
	
		//only say fatal error, if the last error has been fatal!
		if ($type==E_ERROR or $type==E_CORE_ERROR or $type==E_PARSE or $type==E_COMPILE_ERROR or $type==E_USER_ERROR)
		{
			if (strpos($e['message'],"ErrorException")===false) //exceptions automatically have filename in their message
				echof ("Fatal Error ?: ? [?:<strong>?</strong>]",$e['type'],$e['message'],$e['file'],$e['line']);
			else
				echo_br("Fatal Error {$e['type']}: {$e['message']}");
			exit(1);
		}
	}
	
	/**
	 * Converts a php error to a php exception (ErrorException)
	 * You don't need to call this directly.
	 * @param type $errMsg
	 * @param type $errNo
	 * @param type $errFile
	 * @param type $errLine
	 * @throws ErrorException
	 */
	public static function _errorToException( $errNo ,$errMsg, $errFile = null, $errLine = null,$errContext=null)
	{
		throw new \ErrorException($errMsg, $errNo, 0, $errFile, $errLine);
	}
	
	/**
	 * Dumps an exception in readable format
	 * @param Exception $e
	 */
	public static function dump(\Exception $e)
	{
		echof ($e->getTraceAsString());
	}
	
	
    /**
     * 
     * @param unknown $errno
     * @param unknown $errstr
     * @param unknown $errfile
     * @param unknown $errline
     */
    public static function devel($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)){
            return;
        }
        

        switch($errno)
        {
        	case E_ERROR:
        	    echo '[PHP Error #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_WARNING:
        	    echo '[PHP Warning #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_PARSE:
        	    echo '[PHP Parse #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_NOTICE:
        	    echo '[PHP Notice #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_CORE_ERROR:
        	    echo '[PHP Core #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_CORE_WARNING:
        	    echo '[PHP Core warning #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_COMPILE_ERROR:
        	    echo '[PHP Compile #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_COMPILE_WARNING:
        	    echo '[PHP Compile warning #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_USER_ERROR:
        	    echo '[PHP Error #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_USER_WARNING:
        	    echo '[PHP User warning #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_USER_NOTICE:
        	    echo '[PHP User notice #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_STRICT:
        	    echo '[PHP Strict #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	case E_RECOVERABLE_ERROR:
        	    echo '[PHP Recoverable error #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        	    break;
        	default:
        	    echo '[PHP Unknown error #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')';
        }
        
        echo '<pre>';debug_print_backtrace();echo '</pre>';
        
        die;
        return true;
    }

    /**
     * 
     * @param unknown $errno
     * @param unknown $errstr
     * @param unknown $errfile
     * @param unknown $errline
     */
    static public function prod($errno, $errstr, $errfile, $errline)
    {
        
        if (!(error_reporting() & $errno)){
            return;
        }
        
        
        switch($errno)
        {
        	case E_ERROR:
        	    Stack::getInstance()->addError( '[PHP Error #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_NOTICE_ERROR_ );
        	    break;
        	case E_WARNING:
        	    Stack::getInstance()->addError( '[PHP Warning #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_WARNING_ERROR_ );
        	    break;
        	case E_PARSE:
        	    Stack::getInstance()->addError( '[PHP Parse #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_FATAL_ERROR_ );
        	    break;
        	case E_NOTICE:
        	    Stack::getInstance()->addError( '[PHP Notice #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_NOTICE_ERROR_ );
        	    break;
        	case E_CORE_ERROR:
        	    Stack::getInstance()->addError( '[PHP Core #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_FATAL_ERROR_ );
        	    break;
        	case E_CORE_WARNING:
        	    Stack::getInstance()->addError( '[PHP Core warning #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_FATAL_ERROR_ );
        	    break;
        	case E_COMPILE_ERROR:
        	    Stack::getInstance()->addError( '[PHP Compile #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_FATAL_ERROR_ );
        	    break;
        	case E_COMPILE_WARNING:
        	    Stack::getInstance()->addError( '[PHP Compile warning #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_FATAL_ERROR_ );
        	    break;
        	case E_USER_ERROR:
        	    Stack::getInstance()->addError( '[PHP Error #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_FATAL_ERROR_ );
        	    break;
        	case E_USER_WARNING:
        	    Stack::getInstance()->addError( '[PHP User warning #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_WARNING_ERROR_ );
        	    break;
        	case E_USER_NOTICE:
        	    Stack::getInstance()->addError( '[PHP User notice #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_NOTICE_ERROR_ );
        	    break;
        	case E_STRICT:
        	    Stack::getInstance()->addError( '[PHP Strict #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_FATAL_ERROR_ );
        	    break;
        	case E_RECOVERABLE_ERROR:
        	    Stack::getInstance()->addError( '[PHP Recoverable error #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_WARNING_ERROR_ );
        	    break;
        	default:
        	    Stack::getInstance()->addError( '[PHP Unknown error #'.$errno.'] '.$errstr.' ('.$errfile.', line '.$errline.')', _UFO_NOTICE_ERROR_ );
        }
        die;
        return true;
    }
}

?>