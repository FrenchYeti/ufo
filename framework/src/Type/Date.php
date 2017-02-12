<?php

namespace Ufo\Type;

class Date implements TypeInterface
{
    static public $Formats = array(
        'FR'=>'(?:[012][0-9]|3[01])/(?:0?[1-9]|1[012])/(?:[0-9]{2}|[0-9]{4})',
        'EN'=>'(?:0?[1-9]|1[012])/(?:[012][0-9]|3[01])/(?:[0-9]{2}|[0-9]{4})',
        'TIMESTAMP'=>'\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}',
        'CUSTOM'=>null,	
    );
    
    public $limit = -1;
    
    private function _makeFormat($format_str)
    {
        $p = null;

        return $p;
    }
    
    public function __construct($format_const, $customFormat_str = null)
    {
        
        if($format_const == 'CUSTOM'){
            $this->_execPattern = $this->makeFormat($customFormat_str);    
        }
        elseif(isset(self::$Formats[$format_const])){
            $this->_execPattern = self::$Formats[$format_const];
        }
        else{
            throw new Exception();
        }
            
    }
    
    public static function _()
    {
        $args = func_get_args();
        $type = get_called_class();
    
        return new $type($args[0],isset($args[1])? $args[1] : null);
    }
    
    public function checkLimit($value_str)
    {
        if($this->limit < 0) return true;
    
        return (mb_strlen($value_str) > $this->limit);
    }
    
    public function is($value_str)
    {
        if(!$this->checkLimit($value_str)) return false;
    
        if(filter_var($param_text_str,FILTER_VALIDATE_EMAIL)){
            return true && $v && $c ;
        }
        else{
            return ((bool)preg_match($this->_execPattern, $value_str) && $v && $c);
        }
    }
    
    public function check($value_str)
    {
        if($this->is($value_str))
            return $value_str;
        else
            return false;
    }
    
    public function sanitize($value_str)
    {
        throw new SanitizeException('NOT_SANITIZABLE');
    }
    
    public function separators()
    {
        $sep = func_get_args();
        foreach($sep as $i=>$a){
            $this->_execPattern = str_replace('$SEP'.$i.'$', $a, $this->_execPattern);
        }    
    }
    
    public function __get($ppt)
    {
        if($ppt == 'Flags')
            throw new SanitizeException('NO_FLAG');
    
        if($ppt == 'Pattern')
            throw new SanitizeException('NO_PATTERN');
    
    }
    
    public function __call($ppt)
    {
        if($ppt == 'mod')
            throw new SanitizeException('NOT_MODABLE');
    
        if($ppt == 'flags')
            throw new SanitizeException('NOT_FLAGABLE');
    }
}