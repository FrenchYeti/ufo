<?php


class Chien
{
	public function aboie()
	{
		echo 'Waf waf';
	}	
}

class ObjectProxy
{
	const BEFORE = 0;
	const ON = 1;
	const AFTER = 2;

	protected $_EHList = array();	

	public $finalObj = null;

	protected function callEventHandler($pos_const,$methodName_str)
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



class ObjectManager
{
	protected static $_instance = null;

	public $managed = array();

	protected function __construct(){}
	protected function __clone(){}

	public static function getInstance()
	{
		if( self::$_instance === NULL)
			self::$_instance = new ObjectManager();
		
		return self::$_instance;
	}		

	public static function attach( $objectname, $object)
	{
		$self = self::getInstance();
		$self->managed[$objectname] = new ObjectProxy($object);
	}

	public static function detach( $objectname)
	{
		$self = self::getInstance();
		unset($self->managed[$objectname]);
	}	

	public static function get($objectname)
	{
		$self = self::getInstance();
		return $self->managed[$objectname];
	}
}

class Session
{
	public $id = null;

	public function __construct()
	{
		$this->id = uniqid();
	}


	public function sessionStart()
	{
		echo 'la session commence ...<br>';
	}
}

class SessionManager extends ObjectManager
{
	public static function newSession( $name)
	{
		self::getInstance()->attach( $name, new Session());
	}

	public static function startSession( $name)
	{
		self::getInstance()->get($name)->sessionStart();
	}
}


/*
$punt = new Chien();
ObjectManager::attach('punt', new Chien());
ObjectManager::get('punt')->_before('aboie',function(){
	echo 'Le chien va aboyer<br>';
});
ObjectManager::get('punt')->_after('aboie',function(){
	echo 'Le chien a aboy&eacute;<br>';
});
*/


SessionManager::newSession('espace_auth');
SessionManager::get('espace_auth')->_before('sessionStart',function($obj,$args){
	echo 'EVENT : La session "espace_auth" va commencer => ID : '.$obj->id.'<br>';
});

SessionManager::startSession('espace_auth');

?>
