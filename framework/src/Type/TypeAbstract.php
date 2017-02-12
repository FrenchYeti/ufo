<?php

namespace Ufo\Type;

use Ufo\Security\mb_strlen;
/**
 * 
 * 
 * is() -> check if value is correct for type and return TRUE or FALSE
 * check() -> check is() and return value if ok, else FALSE
 * sanitize() -> remove all unvailable character to make valide value from invalid value
 * 
 * mustValidate() -> set additionnal pattern to check if value is correct ( after is() )
 * mod() -> to add character in pattern
 * flag() -> to allow group of char by his label (if predefined) (space, num, etc ... )
 * 
 * _() -> STATIC : To create new derived type ( type with length defined )
 * 
 * 
 * 
 * @author gbmichel
 *
 */
abstract class TypeAbstract
{
    static public $Flags = array();
    
    static public $Pattern;
     
    public $limit;
    
    public $_execPattern = null;
    public $_validate = null;
    
    
    public function __construct($limit_int = -1)
    {
        $this->_limit = $limit_int;
        $this->_execPattern = self::$Pattern;
    }
    
    protected function checkLimit($value_str)
    {
        if($this->_limit < 0) return true;

        return (mb_strlen($value_str) <= $this->_limit);       
    }
    
    protected function checkPattern($value_str)
    {
        return preg_match('/\A['.$this->_execPattern.']+\z/u',$value_str);    
    }
    
    protected function checkSpecial($value_str)
    {
        return (strpos( $value_str, chr(0))>0)? false : true ;
    }
    
    protected function checkValidation($value_str)
    {
        return preg_match($this->_validate,$value_str);
    }
    
    /**
     * To check if value is valid else return false
     * 
     * @param unknown $value_str
     * @return boolean|number
     */
    public function is($value_str)
    {
        if(!$this->checkSpecial($value_str)) return false;
        if(!$this->checkLimit($value_str)) return false;
        
        $f = (bool) $this->checkPattern($value_str);
        
        if(($f !== false)&&($this->_validate !== null))
            return $f && $this->checkValidation($value_str); 
        else 
            return $f;    
    }
    
    /**
     * To check if value is valid, if the value is valid, she's returned 
     * 
     * @param unknown $value_str
     * @return Ambigous <boolean, unknown>
     */
    public function check($value_str)
    {
        return ($this->is($value_str))? $value_str : false ; 
    }
    
    /**
     * Keep only allowed characters in the value and return them  
     * 
     * @param unknown $value_str
     */
    public function sanitize2($value_str)
    {
        $m = '';
        $l = mb_strlen($value_str);
        for($i=0;$i<$l;$i++)
        {
            if(preg_match( $this->_pattern, $value_str[$i])) $m .= $value_str[$i];
        }
        
        return $m;
    }
    
    public function sanitize($value_str)
    {
        $v = preg_replace('[^'.$this->_execPattern.']', '', $value_str);
        if(mb_strlen($v) <= $this->_limit) $v = substr($v,0,$this->_limit);
        
        return $v;
    }

    /**
     * To modif pattern
     */
    public function mod($chars_str)
    {
        $this->_execPattern .= preg_quote($chars_str,'/');
        return $this;
    }
    
    /**
     * To use options or subpattern
     * 
     * Number::_(14)->flag('space')->mod(',')->validate('$3,$3,$3 $5');
     */
    public function flag()
    {
        $cls = get_called_class();
        $flgs = func_get_args();
        foreach($flgs as $f){
            if(isset($cls::$Flags[$f])) $this->_execPattern .= $cls::$Flags[$f];
        }            
        return $this;
    }
    
    public static function _()
    {
        $args = func_get_args();
        $type = get_called_class();
        
        return new $type($args[0]);
    }
    
    /**
     * 
     * [a-z]{3}\s[a-z]{3}\s[a-z]{3}\s[a-z]{5}
     * 
     * @param unknown $pattern
     */
    public function mustValidate($pattern)
    {
        $this->_validate = $pattern;
    }
}

?>