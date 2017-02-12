<?php

namespace Ufo\Captcha\Exception;

use Ufo\Log\Trace as Trace;

/**
 *
 * @author gb-michel
 *        
 */
class RuntimeException
{

    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        Trace::add(_UFO_LOG_RUNNING_,'[CAPTCHA]'.$this->__toString());

        parent::__construct($message, $code, $previous);
    }
    

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

?>