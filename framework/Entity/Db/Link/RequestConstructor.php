<?php

namespace Ufo\Entity\Db\Link;


class Where
{
    public function __construct(){
        
    }    
}


class QueryConstructor
{
    private $_entity = null;
    private $_entityAdapter = null;
    private $_entityProperties = null;
    
    public function __construct($entity_str)
    {
        $this->_entityAdapter = $entity_str::getAdapter();            
        $this->_entityProperties = $entity_str::getProperties();
    }
    
    public function select()
    {
        if(func_get_arg(1) == "*"){
            $cols = $this->_entityProperties;     
        }
        else{
            $cols = func_get_args();
        }
        
        
    }
}



$e = new Query();
$e->select("*");

?>