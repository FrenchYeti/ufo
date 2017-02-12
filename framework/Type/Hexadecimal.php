<?php

namespace Ufo\Type;

include 'TypeAbstract.php';



class Hexadecimal extends TypeAbstract
{
    static public $Flags = array(
        'low'=>'abcdef',
        'up'=>'ABCDEF',
        'no_case'=>'abcdefABCDEF'	
    );
    
    static public $Pattern = '0123456789abcdefABCDEF';
    
    public $_execPattern = null;
    
    final public function flag($flag)
    {
        $this->_execPattern = '0123456789';
        
        $o = parent::flag($flag);
        return $o;
    }
}

// $hex4 = Hexadecimal::_(8)->flag('no_case');
// var_dump($hex4);
// var_dump($hex4,$hex4->is('ABef34'));
?>