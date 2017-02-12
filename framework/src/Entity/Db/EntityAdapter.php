<?php
namespace Ufo\Entity\Db;


/**
 * 
 * 
 * @author gb-michel
 *
 */
abstract class EntityAdapter
{
    protected static $_instance = null;
    protected static $initialized = false;
    
    protected $tableLink = null;
    protected $columnLinks = array();
    
    public $defaultsColumn = array();
    
    abstract protected function initialize();
    
    /**
     *
     */
    protected function __construct()
    {
        $this->initialize();
    }
    

    
    /**
     *
    */
    final public static function get()
    {
        static $instance = array();
        
        $called_cls = get_called_class();
        
        if(!isset($instance[$called_cls])){
            $instance[$called_cls] = new $called_cls();
        }
         
        return $instance[$called_cls];
    }
    
    
    final private function __clone()
    {
        
    }
    
    /**
     *
     * @return \Ufo\Entity\Db\TableLink
     */
    public function getTableLink()
    {
        return $this->tableLink;
    }
    
    
    /**
     * 
     * @param string $property_str
     * @return Ambigous <boolean, multitype:>|multitype:
     */
    final public function getColumnLinks( $property_str = null)
    {
        if( $property_str !== null){
            return isset($this->columnLinks[$property_str])? $this->columnLinks[$property_str] : false ;
        }
        else{
            return $this->columnLinks;
        }
    }
    
    
    /**
     * 
     * @param unknown $property_str
     * @param unknown $columnlnk_obj
     */
    final public function addColumnLink( $propertymix_str , $columnlnk_obj = null)
    {
        if(is_array($propertymix_str)){
            foreach($propertymix_str as $ppt=>$col){
                $this->columnLinks[$ppt] = $col;
            }   
        }
        else{
            $this->columnLinks[$property_str] = $columnlnk_obj;
        }    
    }
    
    final public function columnDefaults($ppts_mix, $value_mix = null)
    {
        if(is_array($ppts_mix)){
            $this->defaultsColumn = $ppts_mix;   
        }
        else{
            $this->defaultsColumn[$ppts_mix] = $value_mix; 
        }
    }
    
    final public function defaults($property_mix = null)
    {
        if(isset($this->defaultsColumn[$property_mix])){
            return $this->defaultsColumn[$property_mix];
        }
        else{
            return $this->defaultsColumn;
        }
    }
    
    /**
     *
     * @return boolean
     */
    public static function isInitialized()
    {
        return self::$initialized;
    }
    
}