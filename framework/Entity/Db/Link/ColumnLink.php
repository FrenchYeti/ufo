<?php

namespace Ufo\Entity\Db\Link;

use Ufo\Entity\Db\Check\TemplateCommand;


/**
 * 
 * @author gb-michel
 *
 */
class ColumnLink 
{
	const T_STR = \PDO::PARAM_STR;
	const T_INT = \PDO::PARAM_INT;
	const T_LOB = \PDO::PARAM_LOB;
	const T_NULL = \PDO::PARAM_NULL;
	
	private $_column_name = null;
	private $_column_type = null;
	private $_length = null;
	private $_facultative = true;
	private $_nullable = false;
	private $_type = null;
	
	/**
	 * 
	 * @param unknown $name_str
	 * @return boolean
	 */
	public static function checkName( $name_str)
	{
		$m = array();
		preg_match('#^[\p{L}_]+$#',$name_str,$m);
		
		// 64  is max length of table name in MySQL
		return (($m[0]==$name_str)&&(strlen($name_str)<64))? true : false;
	}
	
	
	/**
	 * 
	 * @param string $colname_str
	 * @param const $coltype_const
	 * @param integer $collength_int
	 * @param boolean $facultative_bool
	 * @param Check\TemplateCommand $tpl_obj
	 */
	public function __construct(
			$colname_str, $coltype_const, $collength_int, $type_obj = null)
	{
		$this->_column_name = $colname_str;
		$this->_length = $collength_int;
		$this->_column_type = $coltype_const;
		$this->_type = $type_obj;
	}
	
	/**
	 * 
	 * @return unknown
	 */
	public function getName()
	{
		return $this->_column_name;	
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getMaxLength()
	{
		return (int)$this->_length;
	}
	
	/**
	 * 
	 * @return unknown
	 */
	public function getType()
	{
		return $this->_column_type;
	}
	
	
	/**
	 * 
	 * @param unknown $data_mixed
	 */
	public function check($data_mixed)
	{
	    if(($this->_facultative==true)&&(is_null($data_mixed)||$data_mixed=='')){
	        return ($data_mixed==null)? null : '' ;
	    }
	    elseif( $this->_templatecmd->check($data_mixed) !== false){
	        if($this->getType() == self::T_INT){
	            return (int)$data_mixed;
	        }
	        else{
	           return $data_mixed;
	        }
	    }
	    else{
	        return false;
	    }
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isFacultative()
	{
		return $this->_facultative;
	}
	
	static public function _int($colname_str, $length_int, $defaults_arr = null)
	{
	   $o = new ColumnLink($colname_str, self::T_INT, $length_int);    
	   return $o->setDefaults($defaults_arr);
	}
	
	static public function _string($colname_str, $length_int, $defaults_arr = null)
	{
	    $o = new ColumnLink($colname_str, self::T_STR, $length_int);
	    return $o->setDefaults($defaults_arr);
	}
	
	static public function _lob($colname_str, $length_int, $defaults_arr = null)
	{
	    $o = new ColumnLink($colname_str, self::T_LOB, $length_int);
	    return $o->setDefaults($defaults_arr);
	}
	
	/**
	 * @todo Add setter for facultative property
	 */
	/*
	public function facultative($bool)
	{
	    $this->_facultative = 
	}*/
}