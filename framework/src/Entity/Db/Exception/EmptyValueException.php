<?php

namespace Ufo\Entity\Db\Exception;

use Ufo\Log\Trace;

/** 
 * @author gb-michel
 * 
 */
class EmptyValueException extends \Exception
{    
    public function __construct($message, $property = 'unknow', $code = 0, \Exception $previous = null)
    {
        Trace::add(_UFO_LOG_RUNNING_,'[Check data]'.$message.'(Property : '.$property.')');
    
        parent::__construct($message, $code, $previous);
    } 
}

?>