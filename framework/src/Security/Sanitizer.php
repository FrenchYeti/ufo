<?php


namespace Ufo\Security;

use Ufo\HTTP\TaintedString;




/** 
 * Sanitizer::on('chaine de caractere')->asString()
 *   ->removeQuotes()
 *   ->removeSpaces()
 *   ->get()
 *   
 * With tainted input :
 * Sanitizer::on($_POST['login'])->withCheck('pureText',true,false,100)
 * 
 * @author gb-michel
 * 
 */
class Sanitizer
{
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'int';
    const TYPE_FLOAT = 'float';
    const TYPE_BOOLEAN = 'bool';
    
    
    static private $_instance = null;
    
    private $_exited = false;
    private $_value = null;
    private $_tainted = true;
    private $_type = null;
      
    private function __construct()
    {}
    
    
    /**
     * 
     * @method Sanitizer Remove a char from a string by ASCII char code.
     * @param string $string String to clean 
     * @param int $charcode_int Character code in ASCII charset
     * @return Sanitizer 
     */
    private function removeChar( &$string, $charcode_int)
    {
        for($i=0;$i<strlen($string);$i++){
            if(ord($string[$i]) == $charcode_int){
                $string[$i] = '';
            }
        }
        
        return $this;
    }
    
    
    /**
     * 
     * @param unknown $value_mixed
     * @param unknown $type_const
     * @return Sanitizer
     */
    public static function on( $value_mixed)
    {
        if( is_null(self::$_instance)){
            $o = self::$_instance = new Sanitizer();   
        }
        else{
            $o = self::$_instance;
        }
        
        $o->_value = $value_mixed;
        
        return $o;
    }
    
    
    /**
     * Chainable
     * 
     * @method int Sanitize une valeur representant un entier
     * @param int $values_mixed Variable content une valeur de type inconnu
     * @param mixed $default_int Valeur a retourner par defaut, doit etre un entier
     * @return int Retourne la valeur sanitizee
     * @author GB Michel
     * @since 19/09/2013
     * @version 1.2
     */
    public function asInteger($default_int)
    {
        if( is_numeric($this->_value)){
            $this->_value = intval( $this->_value, 10);
        }
        else{
            if( !is_int($default_int)){
                // Add logic error
                $this->_value = 0;                
            }
            else{
                $this->_value = $default_int;
            }         
        }
        
        return $this;
    }

    
    /**
     * Chainable
     * 
     * @method float Sanitize une valeur representant un float
     * @param float $values_mixed Variable contenant une valeur de type inconnu
     * @param mixed $default_float Valeur a retourner par defaut, doit etre un entier
     * @return float Retourne la valeur sanitizee
     * @author GB Michel
     * @since 19/09/2013
     * @version 1.2
     */
    public function asFloat($default_float)
    {
        if( is_numeric($this->_value)){
            $this->_value = floatval( $this->_value);
        }
        else{
            if( !is_float($default_float)){
                // Add logic error
                $this->_value = 0.0;
            }
            else{
                $this->_value = $default_float;
            }            
        }
        
        return $this;
    }
    
    
    /**
     * Chainable
     * 
     * @param unknown $values_mixed
     * @param unknown $default_string
     * @return Ambigous <string, unknown>|string
     */
    public function asString($default_string)
    {
        if( !is_string($this->_value)){
            
            if( is_string($default_string)){
                // add logic error 
                $this->_value = "";
            }
            else{
                $this->_value = $default_string;
            }
        }    
        else{
            $this->_value = (string)$this->_value;
        }       
        
        return $this;
    }
    
    /**
     * Remake string with only alphanum char and underscore
     * Others chars are replace by a joker
     * 
     * @return string
     */
    public function remakeAsPureText($replaced_char='*')
    {
        $clean = '';
        for( $i=0 ; $i<strlen($this->_value); $i++){
            $c = ord($this->_value[$i]);
            if( (($c >= 48) && ($c <= 57)) || (($c >= 65) && ($c <= 90)) 
                || (($c >= 97) && ($c <= 122)) || ($c == 95)){
                $clean .= chr($c);
            }
            else{
                $clean .= $replaced_char;
            }
        }
        return $clean;
    }
    
    /**
     * Chainable
     * 
     * @method Sanitizer Remove simple quotes in the string 
     * @return Sanitizer Sanatizer instance
     */
    public function removeSimpleQuotes()
    {
        if( !TaintedString::is($this->_value)){
            if( $this->_exited == false){
                return $this->removeChar( $this->_value, 39);
            }
            else{
                return $this;
            }   
        }
        else{
            return null;
        }
    }
    
    
    /**
     * Chainable
     * 
     * @method Sanitizer Remove double quotes in the string 
     * @return Sanitizer Sanatizer instance
     */
    public function removeDoubleQuotes()
    {
        if( !TaintedString::is($this->_value)){
            if( $this->_exited == false){
                return $this->removeChar( $this->_value, 34);
            }
            else{
                return $this;
            }
        }
        else{
            return null;
        }
    }

    
    /**
     * Chainable
     * 
     * @return boolean
     */
    public function get()
    {       
        if( $this->_exited == false){
            return $this->_value;
        }
        else{
            // error
            return false;
        }
    }
    
    
    /**
     * 
     * @param unknown $checkmethod_str
     */
    public function withCheck()
    {
        
    }
    
    
    /**
     * 
     * @param unknown $checkmethod_callback
     */
    public function withRegexp($regexp_str)
    {
    
    }
}

?>