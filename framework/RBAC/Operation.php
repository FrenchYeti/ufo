<?php

namespace Ufo\RBAC;

use Ufo\Security\Check;
use Ufo\Db\Manager as DbManager;
use Ufo\RBAC\Authorization as Authorization;
use Ufo\RBAC\OperationCategorie as OperationCategorie;


class OperationException extends \Exception {}
class InvalidFieldOperationException extends \Exception {}


/**
 * @package UFO
 * @author gb-michel
 * @since 09/01/2014
 */
class Operation 
{
    /**
     * @var int ID of operation
     */
	private $_id = null;
	
	/**
	 * @var string Name of the operation
 	 */
	private $_title = null;
	
	/**
	 * @var string Description of the operation
	 */
	private $_description = null;
	
	/**
	 * @var string Name of the Categorie of the operation
	 */
	private $_categorie = null;
	
	/**
	 * @var int ID of operation categorie
	 */
	private $_pcatid = null;
	
	
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
	 * @static
	 * @param unknown $title_str
	 * @return boolean
	 */
	public static function checkTitle($title_str)
	{
		return Check::specificPureText($title_str,'_',true,true,100);
	}
	
	
	/**
	 *
	 * @param unknown $name_str
	 */
	public static function checkDescription($description_str)
	{
	    return Check::litteralI18nText($description_str,1000,"',.-_;:");
	}
	

	/**
	 * @static
	 * @param unknown $title_str
	 * @throws Exception
	 * @return boolean|NULL
	 */
	public static function checkTitleAsUniqueIndex($title_str)
	{
		if( !self::checkTitle($title_str)){
			throw new InvalidFieldOperationException("ERROR: Invalid title syntax");
			return null;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$res = $db->SQL(
			'SELECT `OPE_ID` 
			FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'` 
			WHERE `OPE_TITLE`= ?'
		,array($title_str));
	
		if( $res !== false){
			if( count($res) == 0){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			throw new OperationException("ERROR: Check title as index failed");
			return null;
		}		
	}
	
	
	/**
	 * 
	 * @param OperationCategorie $cat_obj
	 * @throws OperationException
	 * @throws \Exception
	 * @return boolean|Ambigous <number, NULL, string>
	 */
	public function newOperation( $title_str, $description_str, OperationCategorie $cat_obj)
	{
		if( $cat_obj->getID() == false){
			throw new OperationException("ERROR: Incorrect Operation Categorie ID");
			return false;
		}
		
		if( !self::checkTitle($title_str) || !self::checkDescription($description_str)){
			throw new OperationException("ERROR: Create failed, invalid input");
			return false;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
				
		$id = $db->SQL(
			'INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'`(`OPE_ID`,`OPE_TITLE`,`OPE_DESCRIPTION`,`OPC_ID`) 
			VALUES (NULL,?,?,?)'
		,array($title_str,$description_str,$cat_obj->getID()));
	
		if( $id !== false){
			$this->_id = (int)$id;
			return $id;
		}
		else{
			throw new \Exception("ERROR: Create of a new operation failed");
			return false;
		}		

		
	} 

	/**
	 * 
	 * @param OperationCategorie $cat_obj
	 * @throws OperationException
	 * @return boolean
	 */
	public function changeCategorie( OperationCategorie $cat_obj)
	{		
		if( $this->_id == null){
			throw new OperationException("ERROR: Incorrect ID");
			return false;
		}
		
		if( $cat_obj->getID() == false){
			throw new OperationException("ERROR: Incorrect Categorie ID");
			return false;
		}
		
		if( $cat_obj->getID() == $this->_pcatid){
		    return true;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');

		$res = $db->SQL(
			'UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'` SET `OPC_ID`= ? 
			WHERE `OPE_ID` = ?'
		,array($cat_obj->getID(),$this->_id));
	
		if( $res !== false){
			return true;
		}
		else{
			throw new OperationException("ERROR: Update of the categorie failed");
			return false;
		}		
	}
	
	/**
	 * 
	 * @param unknown $description_str
	 * @throws OperationException
	 * @return boolean
	 */
	public function changeDescription($description_str)
	{
	    if( $this->_id == null){
	        throw new OperationException("ERROR: Incorrect ID");
	        return false;
	    }
	
	    if(self::checkDescription($description_str)==false){
	        throw new OperationException("ERROR: Incorrect Categorie ID");
	        return false;
	    }
	
	    if( $description_str == $this->_description){
	        return true;
	    }
	
	    $db = DbManager::getConnexion('internals/rbac_manager');
	
	    $res = $db->SQL(
	        'UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'` SET `OPE_DESCRIPTION`= ?
			WHERE `OPE_ID` = ?'
	        ,array($description_str,$this->_id));
	
	    if( $res !== false){
	        return true;
	    }
	    else{
	        throw new OperationException("ERROR: Update of the description failed");
	        return false;
	    }
	}
	
	/**
	 * 
	 * @throws OperationException
	 * @return boolean
	 */
	public function deleteOperation()
	{
		if( $this->_id == null){
			throw new OperationException("ERROR: Incorrect ID");
			return false;
		}

		$flag_aut = Authorization::deleteFromOperation($this);
		if( $flag_aut == false){
			return false;	
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		$db->getHandler()->beginTransaction();
		
		$res = $db->SQL(
				'DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'` WHERE `OPE_ID` = ?'
				,array($this->_id));
		$db->getHandler()->commit();
		
		if( $res !== false){
			return true;
		}
		else{
			$db->getHandler()->rollBack();
			throw new OperationException("ERROR: Deletion of the operation failed");
			return false;
		}
	}
	
	
	/**
	 * 
	 * @return string|null 
	 */
	public function getTitle()
	{
		return $this->_title;
	}
	
	
	
	/**
	 * 
	 * @param unknown $title_str
	 * @return boolean
	 */
	public function setTitle($title_str)
	{
		$f = self::checkTitleAsUniqueIndex($title_str);
		if( $f === true){
			$this->_title = $title_str;
			return true;
		}
		elseif( $f === false){
			return false;
		}
		else{
			return false;
		}
	}
	
	
	
	
	
	/**
	 * @static
	 * @throws OperationException
	 * @return multitype:\Udo\RBAC\Operation |boolean
	 */
	public static function getAll()
	{
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$res = $db->SQL(
			'SELECT `OPE_ID`,`OPE_TITLE`,`OPE_DESCRIPTION`,`OPC_ID` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'`'
		);
	
		if($res !== false){
			
			$coll = array();
			foreach($res as $row){
				$coll[] = self::instanciate($row['OPE_ID'], $row['OPE_TITLE'], $row['OPE_DESCRIPTION'], $row['OPC_ID']);
			}
			
			return $coll;
		}
		else{
			throw new OperationException("ERROR: Selecting of all operations failed");
			return false;
		}		
	}
	
	

	
	/**
	 * @static
	 * @method \Udo\RBAC\Operations|NULL Get an Operation by his ID
	 * @param int $id_int ID of operation
	 * @throws OperationException
	 * @return \Udo\RBAC\Operations|NULL Return an instance of Operation if successful, else NULL
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public static function getByID($id_mixed)
	{		
	    self::checkID($id_mixed)? $id = intval($id_mixed,10) : $id = null ;	    
	    if( $id == null){
	        throw new RoleException("ERROR: Incorrect ID");
	        return false;
	    }

		
		$db = DbManager::getConnexion('internals/rbac_manager');
		$result = $db->SQL('SELECT OPE.`OPE_TITLE`, OPE.`OPE_DESCRIPTION`, OPE.`OPC_ID`, OPC.`OPC_TITLE` 
				FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'` AS OPE 
					INNER JOIN `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPECAT_OPC').'` AS OPC ON OPE.OPC_ID = OPC.OPC_ID 
				WHERE OPE_ID = ?', array($id));
		
		if( count($result) == 1){
			
			return self::instanciate($id, $result[0]['OPE_TITLE'], $result[0]['OPE_DESCRIPTION'], $result[0]['OPC_ID'],$result[0]['OPC_TITLE']);
		}
		else{
			return null;
		}
	}
	
	
	/**
	 * To get multiple Operation
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
	    $result = $db->SQL('SELECT OPE.`OPE_ID`, OPE.`OPE_TITLE`, OPE.`OPE_DESCRIPTION`, OPE.`OPC_ID`, OPC.`OPC_TITLE`
				FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'` AS OPE
					INNER JOIN `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPECAT_OPC').'` AS OPC ON OPE.OPC_ID = OPC.OPC_ID
				WHERE OPE_ID IN ('.$marker.')', $params);
	     
	    if( count($result) > 0){
	         
	        $coll = array();
	        foreach($result as $row){
	            $coll[] = self::instanciate($row['OPE_ID'], $row['OPE_TITLE'], $row['OPE_DESCRIPTION'], $row['OPC_ID'], $row['OPC_TITLE']);
	        }
	        return $coll;
	    }
	    else{
	        return null;
	    }
	}
	
	
	/**
	 * @static
	 * @method \Udo\RBAC\Operations|NULL Get an Operation by his ID
	 * @param string $title_str Name of operation
	 * @throws OperationException
	 * @return \Udo\RBAC\Operations|NULL Return an instance of Operation if successful, else NULL
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public static function getByName($title_str)
	{
		if( !self::checkTitle($title_str)){
			throw new OperationException("ERROR: Incorrect title syntax");
			return false;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		$result = $db->SQL('SELECT `OPE_ID`, `OPE_TITLE`, `OPE_DESCRIPTION`, `OPC_ID` 
                    FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'` 
                    WHERE `OPE_TITLE` = ?', array($title_str));
		
		if( count($result) == 1){
			return self::instanciate($result[0]['OPE_ID'], $result[0]['OPE_TITLE'], $result[0]['OPE_DESCRIPTION'], $result[0]['OPC_ID']);
		}
		else{
			return null;
		}
	}
	
	/**
	 * @method integer|boolean Return ID of operation
	 * @return integer|boolean Return the ID, if is not set, return FALSE
	 * @version 0.9
	 * @since 09/01/2014
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
	 * @static
	 * @param unknown $id_int
	 * @param unknown $title_str
	 * @param unknown $pcat_id
	 * @return \Udo\RBAC\Operation
	 */
	public static function instanciate( $id_mixed, $title_str, $description_str, $pcat_id, $cattitle_str = null)
	{
	    self::checkID($id_mixed)? $id = intval($id_mixed,10) : $id = null ;
		
		if( $id == null){
		    throw new RoleException("ERROR: Incorrect ID");
		    return false;
		}
			
		$o = new Operation();
		$o->_id = $id;
		$o->_title = self::checkTitle($title_str)? $title_str : '! Corrupted data detected !';
		$o->_description = (($description_str == '')||(self::checkDescription($description_str)))? $description_str : '! Corrupted data detected !';
		$o->_pcatid = (int)$pcat_id;
		$o->_categorie = OperationCategorie::checkTitle($cattitle_str)? $cattitle_str : null ;
		
		return $o;
	}
	
	/**
	 * @static
	 * @param OperationCategorie $cat_obj
	 * @throws OperationException
	 * @return boolean|multitype:\Udo\RBAC\Operation
	 */
	public static function getFromCategorie( OperationCategorie $cat_obj)
	{		
		if( $cat_obj->getID() == false){
			throw new OperationException("ERROR: Incorrect Categorie ID");
			return false;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$res = $db->SQL(
			'SELECT `OPE_ID`,`OPE_TITLE`,`OPE_DESCRIPTION`,`OPC_ID` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'` WHERE `OPC_ID` = ?'
		,array($cat_obj->getID()));
	
		if($res !== false){
			
			$coll = array();
			foreach($res as $row){
				$coll[] = self::instanciate($row['OPE_ID'], $row['OPE_TITLE'], $row['OPE_DESCRIPTION'], $row['OPC_ID']);
			}
			
			return $coll;
		}
		else{
			throw new OperationException("ERROR: Selecting of operations by categorie failed");
			return false;
		}			

	}
	
	
	public function getCategorieName()
	{
	    return $this->_categorie;
	}
	
	public function getCategorie()
	{
	    return ($this->_pcatid!==null)? \Ufo\RBAC\OperationCategorie::getByID($this->_pcatid) : null;
	}
	
	public function getDescription()
	{
	    return $this->_description;
	}
	
	/**
	 * @method multitype:\Ufo\RBAC\Authorization|boolean Get all authorizations allowed to a Role for this operation
	 * @throws OperationException 
	 * @return multitype:\Ufo\RBAC\Authorization|boolean An array of Authorization, else FALSE if error occurs.
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public function getAuthorizations()
	{		
		return Authorization::getFromOperation($this);
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
	public function toArray( $wrapper_array = array('id'=>'id','title'=>'title','description'=>'description','pcatid'=>'pcatid','categorie'=>'categorie'))
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