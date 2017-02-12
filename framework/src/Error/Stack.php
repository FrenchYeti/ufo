<?php

namespace Ufo\Error;

use Ufo\Log\Trace as Trace;

class Stack
{
	/*
	const NOTICE_ERROR = 1 ;
	const FATAL_ERROR = 2 ;
	const CRITICAL_ERROR = 3 ;
	*/
	
	private static $_instance = null ;
	private $_errorstack = null ;
	
	
	/**
	 * 
	 */
	private function __construct()
	{}
		
	
	/**
	 * 
	 * @return \Ufo\Error\Stack
	 */
	public static function getInstance()
	{
		if( is_null( self::$_instance)){
			self::$_instance = new Stack();
		}
		
		return self::$_instance ;
	}
	
	
	/**
	 * 
	 * @param unknown $msg_str
	 * @param string $level_const
	 */
	public function addError( $msg_str, $level_const = _UFO_NOTICE_ERROR_)
	{
		if( is_null( $this->_errorstack)){
			$this->_errorstack = array();
		}	
		
		$this->_errorstack[] = array('msg'=>$msg_str, 'lvl'=>$level_const, 'time'=>time());
	}
	
	
	/**
	 * 
	 * @param string $separator_str
	 * @return string
	 */
	public function dumpStack( $separator_str = ';')
	{
		if( !is_null( $this->_errorstack)){
			
			$str = '[TIME][LEVEL][MESSAGE];';
			foreach( $this->_errorstack as $err)
			{
				$str .= '['.$err['time'].']['.$err['lvl'].']['.$err['msg'].']'.$separator_str ;
			}
			
			return substr( $str, 0, strlen($str)-strlen($separator_str));
			
		}
		else{
			return '';
		}
	} 
	
	
	/**
	 * 
	 * @return mixed|number
	 */
	public function getLevelMax()
	{
		if( !is_null($this->_errorstack)){
			
			$tmp = array();
			foreach( $this->_errorstack as $err)
			{
				$tmp[] = $err['lvl'];
			}
			
			$m = max($tmp);
			unset( $tmp);
			
			return $m;
		}
		else{
			return 0;
		}
	}
	
	
	/**
	 * 
	 * @param unknown $msg_str
	 * @param unknown $level_int
	 */
	public function manageError( $msg_str, $level_int)
	{
		Trace::add( _UFO_LOG_ERROR_, $msg_str.' (-> Traces generees ) lvl:'.$level_int);
		
		if( $level_int >= 3 ){
			
			
			$trace = $this->dumpStack();
			// MAIL + FICHIER DE LOG
			// REDIRECTION 
		}
		
	}
}
?>
