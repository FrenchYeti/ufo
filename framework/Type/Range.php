<?php

namespace Ufo\Type;

// include 'TypeInterface.php';

class Range implements TypeInterface
{
    public $limit = null;
    public $ranges = array();
    
    public function __construct($values_arr,$separator_str = null)
    {
        if(is_array($values_arr)) 
            $this->ranges = $values_arr;
        elseif(is_string($values_arr)&&($separator_str !== null)) 
            $this->ranges = preg_split($separator_str,$values_arr);        
        
        $this->ranges = array_map(function(){
            return base64_encode(func_get_arg(0));
        },$this->ranges);   
    }
    
    public function is($value_str)
    {
        if(in_array(base64_encode($value_str),$this->ranges))
            return true;
        else 
            return false;
    }
    
    public function check($value_str)
    {
        if($this->is($value_str))
            return true;
        else 
            return false;
    }
    
    public function sanitize($value_str)
    {
        throw new Ufo\Error\SanitizeException('NOT_SANITIZABLE');
    }
    
    static public function _($values_mix)
    {
        return new Range($values_mix);
    }
}

// var_dump(Range::_(array('toto','kiki'))->is('kiko'));

?>
