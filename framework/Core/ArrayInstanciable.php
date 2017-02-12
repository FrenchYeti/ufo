<?php

namespace Ufo\Core;

/**
 * 
 * 
 * @author gbmichel
 *
 */
class ArrayInstanciable
{
    /**
     * To initialize a property
     * 
     * @param string $property_str Property name
     * @param multiple $value_mix Value of the property
     */
    public function initProperty( $property_str, $value_mix)
    {
        $this->$property_str = $value_mix;    
    }

    /**
     * To initialize object from an array
     * 
     * @param unknown $properties_arr
     */
    public function initProperties( $properties_arr)
    {
        foreach($properties_arr as $k=>$v)
        {
            $this->initProperty($k, $v);
        }    
    }
    
    /**
     * To instanciate new object in a Javascript-like style
     * 
     * @param array $config_arr An array where each key is a property and value the property
     * @return Object Intance of the object
     * @version 1.0
     */
    public function __construct($config_arr = array())
    {
        
    }
    
}

?>