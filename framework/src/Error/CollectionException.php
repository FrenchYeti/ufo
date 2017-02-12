<?php

namespace Ufo\Error;

use Ufo\Log\Trace;

/** 
 * @author gb-michel
 * 
 */
class CollectionException extends \Exception
{
    const ADD_OVERWRITE = 1;
    
    
    /**
     * 
     * @param unknown $code_const
     * @return string
     */
    public function getCustomMessage( $code_const)
    {
        switch($code_const)
        {
        	case self::ADD_OVERWRITE:
        	    $msg = 'add() : Try to overwrite entry';
        	    break;
        	default:
        	    $msg = 'unknow error';
        	    break;
        }
        
        return $msg;
    }
    
    
    /**
     * 
     * @param unknown $obj
     * @param unknown $message
     * @param number $code
     * @param \Exception $previous
     */
    public function __construct($obj, $message, $code = 0, \Exception $previous = null)
    {
        $serial = serialize($obj);
        
        Trace::add(_UFO_LOG_RUNNING_,'['.get_class($this).'] Error '.$message.' on :'.$this->getCustomMessage($code).' in file : '.__FILE__.' at line'.__LINE__.'; SERIAL OBJ : '.$serial);
    
        parent::__construct($message.' on :'.$this->getCustomMessage($code), 0, $previous);
    }
}

?>