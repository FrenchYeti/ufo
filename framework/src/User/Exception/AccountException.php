<?php

namespace Ufo\User\Exception;

use Ufo\Log\Trace as Trace;

/**
 *
 * @author gb-michel
 *        
 */
class AccountException extends \Exception
{
    /**
     * 
     * @param string $message
     * @param constant $log_type Type of log
     * @param number $code
     * @param \Exception $previous
     */
    public function __construct($message, $log_type, $code = 0, \Exception $previous = null)
    {
        if( defined($log_type)){
            Trace::add($log_type,'[ACCOUNT]'.$this->__toString());
        }
        else{
            Trace::add(_UFO_LOG_LOGIC_,'[CONSTANT UNDEFINED][ACCOUNT_EXCEPTION]'.$log_type);
            Trace::add(_UFO_LOG_ACCOUNT_,'[ACCOUNT]'.$this->__toString());
        }
        
        parent::__construct($message, $code, $previous);
    }
    
    
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n"; 
    }
}

?>