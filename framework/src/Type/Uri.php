<?php

namespace Ufo\Type;

class Uri implements TypeInterface
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
        ( strpos( $param_text_str, chr(0)) === false )? $c = true : $c = false ;
		if(!$this->checkLimit($value_str)) return false;
        
		$url = parse_url($param_text_str);
		
		if(!isset($url['scheme'])&&isset($url['path'])){
		    
		    isset($url['host'])? $p = $url['host'] : $p = '';
		    
		    return (filter_var('http://'.$p.$url['path'],FILTER_VALIDATE_URL)&&$v&&$c); 
		}
		elseif(isset($url['scheme'])&&isset($url['host'])){
		    
		    isset($url['path'])? $p = $url['path'] : $p = '';
		    
		    return (filter_var($url['scheme'].'://'.$url['host'].$p,FILTER_VALIDATE_URL)&&$v&&$c);
		}
		else{
		    return false;
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