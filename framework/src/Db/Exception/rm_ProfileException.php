<?php

namespace Ufo\Db\Exception;

use Ufo\Log\Trace as Trace;

/**
 *
 * @author gb-michel
 *        
 */
class ProfileException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        Trace::add(_UFO_LOG_DB_,'[DB]'.$this->__toString());
    
        parent::__construct($message, $code, $previous);
    }
    
    
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

?>