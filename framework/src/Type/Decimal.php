<?php

namespace Ufo\Type;

class Decimal extends TypeAbstract
{
    static public $Flags = array(
    	'signed'=>'[-+]'
    );
    
    static public $Pattern = '(?P<int>[0-9]+)\.(?P<dec>[0-9]+)';
    
    private $_signs = '';
    private $_separator = '\.';
    private $_dec  = 0;
    private $_execPattern = null;
    
    /**
     * Overwrite parent::__construct();
     * 
     * @param unknown $size_int
     * @param unknown $nbrdecimal_int
     */
    public function __construct($size_int, $nbrdecimal_int)
    {
        $this->_limit = (int)$size_int;
        $this->_dec = (int)$nbrdecimal_int;
    }
    
    /**
    * Overwrite parent::is()    
    */
    public function is($value_str)
    {
        $t = array();
        if( preg_match_all('#^'.$this->_signs.'(?P<int>[0-9]+)'.$this->_separator.'(?P<dec>[0-9]+)$#',$value_mixed,$t) > 0){
        
            $f = true;
            $f &= (isset($t['dec'][0][0]) && (strlen($t['dec'][0])<=$this->_dec));
            $f &= (isset($t['int'][0][0]) && (strlen($t['int'][0])<=($this->_limit-strlen($t['dec'][0]))));
        
            return (bool)$f;
        }
        else{
            return false;
        }
    }

    
    /**
     * Overwrite parent::flag()
     */
    public function flag()
    {
        $flags = func_get_args();
        
        foreach($flags as $flg){
             if($flg == 'signed') $this->_signs = '[-+]?';           
        }
        
        return $this;
    }
    
    public function separator($char_str)
    {
        $this->_separator = preg_quote($char_str);
    }
}