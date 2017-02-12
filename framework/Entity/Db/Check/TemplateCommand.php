<?php

namespace Ufo\Entity\Db\Check;

class InconcistentDbEntityTemplateCommandException extends \Exception {}



/**
 * 
 * @author gbmichel
 *
 */
class TemplateCommand
{
	private $_fn = NULL;
	private $_args = array();
	
	private $_null = true;
	
	
	/**
	 * 
	 * @throws InconcistentDbEntityTemplateCommandException
	 * @throws DbEntityTemplateCommandException
	 * @return boolean
	 */
	public function __construct()
	{
		if( func_num_args() == 0){
			throw new InconcistentDbEntityTemplateCommandException("ERROR: Check function is not set");
			return false;
		}
		
		$args = func_get_args();
		$fn = array_shift($args);
		
		if( !method_exists('\Ufo\Security\Check', $fn)){
			throw new InconcistentDbEntityTemplateCommandException("ERROR: Function is not a Check's method");
			return false;
		}
		
		$this->_fn = $fn;
		$this->_args = $args;
	}
	
	/**
	 * 
	 * @param unknown $data_mixed
	 */
	public function check($data_mixed)
	{
		$par = $this->_args;
		array_unshift($par, $data_mixed);
		
		return call_user_func_array(array('Ufo\Security\Check',$this->_fn), $par);
	}
}