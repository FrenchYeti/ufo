<?php

namespace Ufo\RBAC;

use Ufo\Security\Check;
use Ufo\Db\Manager as DbManager;


class OperationCategorieException extends \Exception {}
class InvalidFieldOperationCategorieException extends \Exception {}

class OperationCategorie
{
	private $_id = null;
	private $_title = null;
	private $_description = null;
	private $_operations = null;
	
	
	

	/**
	 * ID can be a string or an integer
	 *
	 * @param unknown $id_mixed
	 * @return boolean
	 */
	public static function checkID($id_mixed)
	{
	    if( is_string($id_mixed)){
	        if( !Check::numberText($id_mixed,false,6)){
	            return false;
	        }
	        else{
	            $id_mixed = intval($id_mixed,10);
	        }
	    }
	
	    return Check::shortInt($id_mixed,99999,true);
	}
	
	/**
	 * 
	 * @param string $title_str
	 * @return boolean
	 */
	public static function checkTitle($title_str)
	{
		return Check::specificPureText($title_str, '_', true, true, 100);
	}
	
	/**
	 * 
	 * @param string $description_str
	 * @return boolean
	 */
	public static function checkDescription($description_str)
	{
		return Check::litteralI18nText($description_str,1000,'._;,:-');
	}
	

	/**
	* To instanciate new OperationCategorie with config
	*
	* @method OperationCategorie instanciate( int $id_int, string $title_str, string $description)
	* @param integer $id_int ID of the OperationCategorie
	* @param string $title_str Title of the categorie
	* @param string $description_str Description of the categorie
	* @throws OperationCategorieException
	* @return boolean|\Ufo\RBAC\Operation
	*/
	public static function instanciate( $id_mixed, $title_str, $description_str)
	{
	    self::checkID($id_mixed)? $id = intval($id_mixed,10) : $id = null ;
	     
	    if( $id == null){
	        throw new OperationCategorieException("ERROR: Incorrect ID");
	        return false;
	    }
	
	    $o = new OperationCategorie();
	    $o->_id = $id;
	    $o->_title = self::checkTitle($title_str)? $title_str : '! Corrupted data detected !';
	    $o->_description = (($description_str == '')||(self::checkDescription($description_str)))? $description_str : '! Corrupted data detected !';
	     
	    return $o;
	}
	
	
	/**
	 * 
	 * @param unknown $id_int
	 * @throws OperationCategorieException
	 * @return boolean|\Udo\RBAC\OperationCategorie
	 */
	public static function getByID($id_mixed)
	{
	    self::checkID($id_mixed)? $id = intval($id_mixed,10) : $id = null ;
		
		if( $id == null){
		    throw new RoleException("ERROR: Incorrect ID");
		    return false;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$res = $db->SQL('SELECT `OPC_TITLE`,`OPC_DESCRIPTION` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPECAT_OPC').'` WHERE OPC_ID = ?',array($id));
		if( count($res) == 1){
			$o = new OperationCategorie();
			$o->_id = $id;
			$o->_title = $res[0]['OPC_TITLE'];
			$o->_description = $res[0]['OPC_DESCRIPTION'];
			
			return $o;
		}
		else{
			throw new OperationCategorieException("ERROR: getByID() failed.");
			return false;
		}
	}
	
	
	/**
	 * To get multiple Role
	 *
	 * @method array(Operation) getByIDs( [array IDs] | [int id [,int id [,int id ... ]]] )
	 * @return multitype:|multitype:Ambigous <\Udo\RBAC\Operation, boolean, \Ufo\RBAC\Operation> |NULL
	 */
	public static function getByIDs()
	{
	    $args = func_get_args();
	
	    if(count($args)==0){
	        return array();
	    }
	    elseif(is_array($args[0])){
	        $args = $args[0];
	    }
	
	
	    $marker = '';
	    $params = array();
	    $i = 0;
	    foreach($args as $id){
	        if(self::checkID($id)){
	            $marker .= '?,';
	            $params[$i] = intval($id,10);
	            $i++;
	        }
	    }
	
	    $marker = substr($marker,0,-1);
	    $db = DbManager::getConnexion('internals/rbac_manager');
	    $result = $db->SQL('SELECT `OPC_ID`, `OPC_TITLE`, `OPC_DESCRIPTION`
	        FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPECAT_OPC').'`
	        WHERE OPC_ID IN ('.$marker.')',$params);
	
	    if( count($result) == 1){
	
	        $coll = array();
	        foreach($result as $row){
	            $coll[] = self::instanciate($row['OPC_ID'], $row['OPC_TITLE'], $row['OPC_DESCRIPTION']);
	        }
	        return $coll;
	    }
	    else{
	        return null;
	    }
	}
	
	/**
	 * 
	 * @param string $title_str
	 * @param string $description_str
	 * @throws InvalidFieldOperationCategorieException
	 * @throws OperationCategorieException
	 * @return boolean
	 */
	public function newCategorie( $title_str, $description_str)
	{
		if( !self::checkTitle($title_str)){
			throw new InvalidFieldOperationCategorieException("ERROR: Text's format of title is invalid");
			return false;
		}
		
		if( !self::checkDescription($description_str)){
			throw new InvalidFieldOperationCategorieException("ERROR: Text's format of description is invalid");
			return false;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$id = $db->SQL(
			'INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPECAT_OPC').'`(`OPC_ID`,`OPC_TITLE`,`OPC_DESCRIPTION`) 
			VALUES (NULL,?,?)'
		,array($title_str,$description_str));
		
		if( $id !== false){
			$this->_id = (int)$id;
			$this->_title = $title_str;
			$this->_description = $description_str;
			return true;
		}
		else{
			throw new OperationCategorieException("ERROR: Insertion failed");
			return false;
		}
	}
	
	/**
	 * 
	 * @param unknown $title_str
	 * @throws InvalidFieldOperationCategorieException
	 * @throws Exception
	 * @return boolean
	 */
	public function changeTitle($title_str)
	{
		if( !self::checkTitle($title_str)){
			throw new InvalidFieldOperationCategorieException("ERROR: Text's format of title is invalid");
			return false;
		}
		
		if( $this->_id == null){
			throw new OperationCategorieException("ERROR: Incorrect ID");
			return false;
		}
		
		if($title_str == $this->_title){
		    return true;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
				
		
		$res = $db->SQL(
			'UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPECAT_OPC').'`  
		    SET `OPC_TITLE`= ? 
			WHERE OPC_ID = ?'
		,array($title_str,$this->_id));
	
		if( $res !== false){
			$this->_title = $title_str;
			return true;
		}
		else{
			throw new OperationCategorieException("ERROR: Update failed");
			return false;
		}						
	}
	
	
	/**
	 * 
	 * @param unknown $description_str
	 * @throws InvalidFieldOperationCategorieException
	 * @throws OperationCategorieException
	 * @throws Exception
	 * @return boolean
	 */
	public function changeDescription($description_str)
	{
		if( !self::checkDescription($description_str)){
			throw new InvalidFieldOperationCategorieException("ERROR: Text's format of description is invalid");
			return false;
		}		
		
		if( $this->_id == null){
			throw new OperationCategorieException("ERROR: Incorrect ID");
			return false;
		}
		
		if($description_str == $this->_description){
		    return true;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$res = $db->SQL(
			'UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPECAT_OPC').'` 
		    SET `OPC_DESCRIPTION`= ?  
			WHERE OPC_ID = ?'
		,array($description_str,$this->_id));
	
		if( $res !== false){
			$this->_description = $description_str;
			return true;
		}
		else{
			throw new \Exception("ERROR: Update failed");
			return false;
		}		
	}
	
	/**
	 * 
	 * @throws OperationCategorieException
	 * @throws Exception
	 * @return boolean
	 */
	public function deleteCategorie()
	{		
		if( $this->_id == null){
			throw new OperationCategorieException("ERROR: Incorrect ID");
			return false;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		$db->getHandler()->beginTransaction();		
		
		$res = $db->SQL(
			'DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPECAT_OPC').'` WHERE OPC_ID = ?'
		,array($this->_id));
		
		$db->getHandler()->commit();
		
		if( $res !== false){
			return true;
		}
		else{
		    $db->getHandler()->rollback();
			throw new \Exception("ERROR: Remove failed");
			return false;
		}		
	}
	
	/**
	 * 
	 * @throws Exception
	 * @return multitype:\Udo\RBAC\OperationCategorie |boolean
	 */
	public static function getAll()
	{
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$res = $db->SQL('SELECT `OPC_ID`,`OPC_TITLE`,`OPC_DESCRIPTION` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPECAT_OPC').'`');
	
		if( $res !== false){
			
			$coll = array();
			foreach( $res as $row){
			    
			    self::checkID($row['OPC_ID'])? $id = intval($row['OPC_ID'],10) : $id = null ;
			    
			    if( $id == null){
			        throw new RoleException("ERROR: Incorrect ID");
			        return false;
			    }
			    
				$o = new OperationCategorie();
				$o->_id = $id;
				$o->_title = self::checkTitle($row['OPC_TITLE'])? $row['OPC_TITLE'] : '! Corrupted data detected !';
				$o->_description = (($row['OPC_DESCRIPTION'] == '')||(self::checkDescription($row['OPC_DESCRIPTION'])))? $row['OPC_DESCRIPTION'] : '! Corrupted data detected !';
				$coll[] = $o;
			}

			return $coll;
		}
		else{
			throw new \Exception("ERROR: Select failed");
			return false;
		}		
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getID()
	{
	    if($this->_id !== null){
	        return $this->_id;
	    }
	    else{
	        return false;
	    }
	}
	
	/**
	 * 
	 * @param unknown $ppt
	 * @return NULL
	 */
	public function getTitle()
	{
	    return $this->_title;
	}
	
	/**
	 *
	 * @param unknown $ppt
	 * @return NULL
	 */
	public function getDescription()
	{
	    return $this->_description;
	}
	
	
	/**
	 * 
	 * @return Ambigous <boolean, \Udo\RBAC\multitype:\Udo\RBAC\Operation, multitype:\Udo\RBAC\Operation >
	 */
	public function getOperations()
	{
		return Operation::getFromCategorie($this);
	}
	
	/**
	 * The wrapper if usefull to rename property is the returned
	 * array is destined to be JSON encoded
	 *
	 * Exemple :
	 *
	 * // with : $operation = Operation{ id=1 , name="ExempleOpe" , pcatid=4 }
	 *
	 * Default :
	 * $operation->toArray();
	 * // return : array('id'=>1,'name'=>'ExempleOpe','pcatid'=>4)
	 *
	 * With wrapper :
	 * $operation->toArray( array('opi'=>'id','opn'=>'name','cat'=>'pcatid'));
	 * // return : array('opi'=>1,'opn'=>'ExempleOpe','cat'=>4)
	 *
	 * For use the wrapper : the keys of wrapper are the final key names, and value of wrapper are the
	 * name of property associate
	 *
	 * @method array Return an array representative of object
	 * @param array $wrapper_array An associative array used to change key in the array returned
	 * @return array Return an array representative of object
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public function toArray( $wrapper_array = array('id'=>'id','title'=>'title','description'=>'description'))
	{
	    $tmp = array();
	    foreach( $wrapper_array as $wrap=>$val)
	    {
	        $tmp[$wrap] = $this->{'_'.$val};
	    }
	
	    return $tmp;
	}
}

?>