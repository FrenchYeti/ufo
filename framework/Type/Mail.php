<?php

namespace Ufo\Type;

use Ufo\Error\SanitizeException;

class Mail implements TypeInterface
{
    public $limit = null;
    
    public function __construct($limit_int = -1)
    {
        $this->limit = (int) $limit_int;        
    }
    
    public static function _()
    {
        $args = func_get_args();
        $type = get_called_class();
        
        return new $type($args[0]);
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
            return ((bool)preg_match('/\A[\p{L}\p{N}_+-]+(\.[\p{L}\p{N}_+-]+)*@[\p{L}\p{N}_+-]+\.[\p{L}\p{N}_+-]+(\.[\p{L}\p{N}_+-]+)*\z/u', $param_text_str) && $v && $c);
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
?>