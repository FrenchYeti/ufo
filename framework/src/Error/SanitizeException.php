<?php

namespace Ufo\Error;

class SanitizeException
{
    static public $Codex = array(
        'UNKNOW'=>'[Sanitization] Fatal error : unknow error',
    	'NOT_SANITIZABLE'=>'[Sanitization] Fatal error : value is not sanitizable'
    );
    
    public function __construct($classname_str, $code = 'NOT_SANITIZABLE', \Exception $previous = null)
    {

        if( isset(self::$Codex[$code]))
            $code_msg = self::$Codex[$code];
        else
            $code_msg = 'RUNTIME UNKNOW EXCEPTION';
        
        
        parent::__construct($code_msg, $code, $previous);
    
        //Trace::add(_UFO_LOG_RUNNING_,'<b>'.$code_msg.' in : ['.$classname_str.']</b><br>'.$this->__toString().'');
    }
    
    
    public function __toString()
    {
        $msg = '';
        //if( $this->code !== 0) $msg .= "#{$this->code}";
    
        return $msg." {$this->message}\n";
    }
    
    
}

?>