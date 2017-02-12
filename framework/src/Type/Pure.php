<?php

namespace Ufo\Type;

/**
 * Pure type is a strinf which contains only alpha character
 * If flags are specified, it's can contains numeric and space
 * 
 * This example ARE pure :
 * toto (no flags)
 * toto go to sleep (flags: space)
 * toto123 (flags: num)
 * toto 123 (flags: num,space)
 * 
 * This examples ARE NOT pure :
 * tété 112
 * toto[tab]122
 *   
 * @author gbmichel
 * @version 1.0
 */
class Pure extends TypeAbstract
{
    static public $Flags = array(
        'space'=>'\s',
        'num'=>'0-9'	
    );
    
    static public $Pattern = 'a-z';
}

?>