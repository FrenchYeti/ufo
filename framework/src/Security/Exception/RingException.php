<?php 

namespace  Ufo\Security\Exception;

use \Ufo\Log\Trace as Trace;

class RingException extends \Ufo\Error\StandardException
{
    const DB_QUERY_INSERT_FAILED = 1;
    const DB_QUERY_UPDATE_FAILED = 2;
    const DB_QUERY_DELETE_FAILED = 3;
    const DB_QUERY_EXISTS_FAILED = 4;
    const INVALID_TOKEN = 5;
    const EXPIRED = 6;
    
    public $custom_message = '';
    public $previous = null;
    
    public function runCode($code,$file,$line)
    {
        ($this->previous!==null)? $additional_str = $this->previous->getMessage() : $additional_str = '';
        
        switch($code)
        {
        	case self::DB_QUERY_INSERT_FAILED:
        	    $this->custom_message = 'SQL Query SELECT failed in Ring in : '.$file.'(line : '.$line.')';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY] '.$this->custom_message.', PDOException : '.$additional_str);
        	    break;
        	case self::DB_QUERY_UPDATE_FAILED:
        	    $this->custom_message = 'SQL Query UPDATE failed in Ring in : '.$file.'(line : '.$line.')';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY] '.$this->custom_message.', PDOException : '.$additional_str);
        	    break;
        	case self::DB_QUERY_DELETE_FAILED:
        	    $this->custom_message = 'SQL Query DELETE failed in Ring in : '.$file.'(line : '.$line.')';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY] '.$this->custom_message.', PDOException : '.$additional_str);
        	    break;
        	case self::DB_QUERY_EXISTS_FAILED:
        	    $this->custom_message = 'SQL Query EXISTS failed in Ring in : '.$file.'(line : '.$line.')';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY] '.$this->custom_message.', PDOException : '.$additional_str);
        	    break;
        	case self::INVALID_TOKEN:
        	    $this->custom_message = 'Invalid token';
                Trace::add(_UFO_LOG_SECURITY_,'[RING] Invalid token called in : '.$file.'(line : '.$line.')');
        	    break;
    	    case self::EXPIRED_SUSPICIOUS:
    	        $this->custom_message = 'Illegal use of ring. Ring expired.';
    	        Trace::add(_UFO_LOG_SECURITY_,'[RING] Illegal use of ring in : '.$file.'(line : '.$line.')');
    	        break;
        	case self::EXPIRED:
        	    $this->custom_message = 'Ring expired';
        	    break;
        }
    }
    
    public function __construct($code, $file_str, $line_int, \Exception $previous = null)
    {    
        $this->previous = $previous;
        
        $this->runCode($code, $file_str, $line_int);
    
        parent::__construct('Ufo\Security\Ring','[RING] '.$this->custom_message, $code, $previous);
    }
}

?>