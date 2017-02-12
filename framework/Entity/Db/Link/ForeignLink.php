<?php

namespace Ufo\Entity\Db\Link;

class ForeignLink
{
	private $_entity = null;
	private $_property = null;
	
	private $_herited_tablelink = null;
	private $_herited_columnlink = null;
	
	private $_local_columnname = null;
	private $_facultative = true;
	
	
	/**
	 * 
	 * @param string $colname_str
	 * @param const $coltype_const
	 * @param integer $collength_int
	 * @param boolean $facultative_bool
	 * @param Check\TemplateCommand $tpl_obj
	 */
	public function __construct( $entity_str, $property_str = 'id', $facultative_bool = true, $localcolumnname_str = null)
	{
		if( !class_exists($entity_str,true)){
			// !
		}

		$adapter = call_user_func($entity_str.'::getAdapter');
		
		$this->_herited_tablelink = $adapter->getTableLink();
		$this->_herited_columnlink = $adapter->getColumnLinks($property_str);
		$this->_entity = $entity_str;
		$this->_property = $property_str;
		$this->_facultative = $facultative_bool;
		$this->_local_columnname = $localcolumnname_str;
	}
	
	public function getTableName()
	{
		return $this->_herited_tablelink->getName();
	}
	
	public function getTablePrefix()
	{
	    return $this->_herited_tablelink->getPrefix();
	}
	
	/**
	 * 
	 * @return unknown
	 */
	public function getName()
	{		
	    if($this->_local_columnname !== null){
	        return $this->_local_columnname;
	    }
	    else{
	        return $this->_herited_columnlink->getName();
	    }	
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getMaxLength()
	{
		return (int)$this->_herited_columnlink->getMaxLength();
	}
	
	/**
	 * 
	 * @return unknown
	 */
	public function getType()
	{
		return $this->_herited_columnlink->getType();
	}
	
	/**
	 * @return string Entity name
	 */
	public function getEntity()
	{
	   return $this->_entity;    
	}
	
	/**
	 * To get the columnLink from the entity associate to the current link
	 * 
	 * @return ColumnLink 
	 */
	public function getColumn()
	{
	    return $this->_herited_columnlink;
	}
	
	
	/**
	 * Entity side, foreign link is an entity into property's value of another entity.
	 * In this case, property need to be checked with 
	 *   
	 */
	public function checkAsEntity( $data_obj)
	{
		if( $data_obj instanceof $this->_entity){
			return $data_obj->checkData();
		}
		else{
			return false;
		}
	}
	
	/**
	 * Entity side, foreign link is an entity into property's value of another entity.
	 * In this case, property need to be checked with
	 *
	 */
	public function checkAsProperty( $data_mixed, $property_str=null)
	{
	    if($property_str==null){
	        $property_str = $this->_property;
	    }
	    
	    if(($this->_facultative==true)&&(is_null($data_mixed)||$data_mixed=='')){
	        return ($data_mixed==null)? null : '' ;
	    }
		elseif( property_exists($this->_entity, $property_str)){
			
			$adapter = call_user_func($this->_entity.'::getAdapter');
			
			if( $adapter !== false){				
				return $adapter->getColumnLinks($property_str)->check($data_mixed);
			}
			else{
				return false;
			}
		}		
		else{
			return false;
		}
	}
	
	
	/**
	 * Abstract side, foreign link is representation of a foreign key and she need to be 
	 * checked as an ID
	 */
	public function check( $data_str)
	{
		return $this->_herited_columnlink->check($data_str);
	}

	/**
	 * 
	 * @return string
	 */
	public function getPropertyName()
	{
	   return $this->_property;    
	}
	
	/**
	 * 
	 * @return mixed
	 */
	public function getForeignAdapter()
	{
	    return call_user_func($this->_entity.'::getAdapter');
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isFacultative()
	{
		return $this->_facultative;
	}
	
	
	/**
	 * To check if an object correspond to the entity of link 
	 *
	 * @param unknown $object
	 * @return boolean
	 */
	public function isSameEntity($object)
	{
	    return ($object instanceof $this->_entity);
	}
	
	
	/**
	 * To check if a column has a local name
	 * 
	 * @return boolean
	 */
	public function hasLocalName()
	{
	    return ($this->_local_columnname == null)? false : true;
	}
}