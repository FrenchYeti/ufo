<?php

namespace Ufo\Core;

/**
*
* @author GB Michel
* @since 02/02/2014
*
*/
class ObjectProxy
{
	const BEFORE = 0;
	const ON = 1;
	const AFTER = 2;

	protected $_EHList = array();	

	public $finalObj = null;

	final protected function callEventHandler($pos_const,$methodName_str)
	{
		$args = func_get_args();
		$pos = array_shift($args);
		$method = array_shift($args);

		if( isset($this->_EHList[$method][$pos])){
			foreach( $this->_EHList[$method][$pos] as $eh){
				call_user_func_array($eh,$args);
			}
		} 
	}

	public function __construct( $finalObj_obj)
	{
		$this->finalObj = $finalObj_obj;
	}

	public function __call( $methodName_str, $args_array)
	{
		$this->callEventHandler( self::BEFORE, $methodName_str, $this->finalObj, $args_array);

		$this->callEventHandler( self::ON, $methodName_str, $this->finalObj, $args_array);

		$result = call_user_func_array( array($this->finalObj,$methodName_str), $args_array);

		$this->callEventHandler( self::AFTER, $methodName_str, $this->finalObj, $args_array, $result);

		return $result;
	}
	
	public static function __callStatic( $methodName_str, $args_array)
	{
		$this->callEventHandler( self::BEFORE, $methodName_str, $this->finalObj, $args_array);
	
		$this->callEventHandler( self::ON, $methodName_str, $this->finalObj, $args_array);
	
		$result = call_user_func_array( get_called_class().'::'.$methodName_str, $args_array);
	
		$this->callEventHandler( self::AFTER, $methodName_str, $this->finalObj, $args_array, $result);
	
		return $result;
	}

	public function _after($methodName_str, $function_fn)
	{ 
		$this->_EHList[$methodName_str][self::AFTER][] = $function_fn;
	}

	public function _before($methodName_str, $function_fn)
	{ 
		$this->_EHList[$methodName_str][self::BEFORE][] = $function_fn;
	}

	public function _on($methodName_str, $function_fn)
	{ 
		$this->_EHList[$methodName_str][self::ON][] = $function_fn;
	}

	public function _getObject()
	{
		return $finalObj;
	}
}

interface ObjectManagerInterface
{
	//public $_instance;
	
	public static function getInstance();
	
	public function attach();
	
	public function detach();
	
	public function get();
}

/**
* @author GB Michel
* @since 02/02/2014
*/
class ObjectManager
{
	// abstract protected $_instance;
	
	public $managed = array();

	protected function __construct(){}
	protected function __clone(){}

	/*
    final public static function getInstance()
    {
        static $instance = array();
        
        $called_cls = get_called_class();
        
        if(!isset($instance[$called_cls])){
            $instance[$called_cls] = new $called_cls();
        }
        
        return $instance[$called_cls];
    }
	
    final public static function getInstance()
    {
    	$called_cls = get_called_class();
    	
    	if( $called_cls::$_instance == null){

    		var_dump('Cons : ',$called_cls);
    		$called_cls::$_instance = new $called_cls();
    	}
    	
    	return $called_cls::$_instance;
    }*/
    
    /**
     * @static
     * @method void attach( string $objectname, object $object) Add a object identified by his name in store 
     * @param string $objectname Name of the object in the store
     * @param object $object Object to store
     */
	final public function attach( $objectname, $object)
	{
		if( class_exists(get_class($object).'Proxy',true)){	
			$class = get_class($object).'Proxy';
			$this->managed[$objectname] = new $class($object);
		}
		else{
			$this->managed[$objectname] = new ObjectProxy($object);
		}
	}

	final public function detach( $objectname)
	{
		unset($this->managed[$objectname]);
	}	

	final public function get($objectname)
	{
		return $this->managed[$objectname];
	}
}



?>
