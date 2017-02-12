<?php

namespace Ufo\Type;

class Number extends TypeAbstract
{
    static public $Pattern = '\p{N}';  

    static public $Flags = array(
        'space'=>'\p{Zs}'
    );
} 

?>