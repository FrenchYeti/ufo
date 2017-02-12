<?php

namespace Ufo\Entity\Db\Link;

class TableLink
{
	private $_name = null;
	private $_prefix = null;
	
	/**
	 * 
	 * @param unknown $name_str
	 * @return boolean
	 */
	public static function checkName( $name_str)
	{
		$m = array();
		preg_match('#^[TtJj]{1,2}_[\p{L}_]+$#',$name_str,$m);
		
		// 64  is max length of table name in MySQL
		return (($m[0]==$name_str)&&(strlen($name_str)<64))? true : false;
	}
	
	
	/**
	 * 
	 * @param unknown $prefix_str
	 * @return boolean
	 */
	public static function checkPrefix( $prefix_str)
	{
		$m = array();
		preg_match('#^[\p{L}_]+$#',$prefix_str,$m);
		
		return (($m[0]==$prefix_str)&&(strlen($prefix_str)<64))? true : false;
	}
	
	/**
	 * 
	 * @param unknown $name_str
	 * @param unknown $prefix_str
	 * @return NULL
	 */
	public function __construct( $name_str, $prefix_str)
	{
		if( !self::checkName($name_str)){
			return null;
		}
		if( !self::checkPrefix($name_str)){
			return null;
		}
		
		$this->_name = $name_str;
		$this->_prefix = $prefix_str;
	}
	
	
	/**
	 * 
	 * @return unknown
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	
	/**
	 * 
	 * @return unknown
	 */
	public function getPrefix()
	{
		return $this->_prefix;
	}
}
