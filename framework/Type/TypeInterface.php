<?php

namespace Ufo\Type;

interface TypeInterface
{
    static public function _($values_mix);
    
    public function is($value_str);

    public function check($value_str);
    
    public function sanitize($value_str);
}

?>