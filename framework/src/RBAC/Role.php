<?php

namespace Ufo\RBAC;

use Ufo\Db\Manager as DbManager;
use Ufo\Security\Check as Check;
use Ufo\Error\CorruptedDataException as CorruptedDataException;


class RoleException extends \Ufo\Error\StandardException 
{
    public function __construct( $calledmethod_str = '', $message_str = '', $code=2)
    {
        parent::__construct('Ufo\RBAC\Role',' 
            -- On : <i>'.$calledmethod_str.'</i> <br>
            -- Exception caught : <i>'.get_class($this).'</i> <br>
            -- Message : <i>'.$message_str.'</i><br>
            -- File : '.$this->getFile().' at line : '.$this->getLine().'<br>'
        ,$code);
    }
}


class RoleIDInvalidException extends RoleException {}
class RoleNameInvalidException extends RoleException {}
class RoleNotExistsException extends RoleException {}
class InvalidFieldRoleException extends RoleException {}


/**
 * 
 * @author GBMichel
 *
 */
class Role
{
	private $_id = null;
	private $_name = null; 	
	private $_dbprofile = null;
	private $_description = null;
	private $_authorizations = null;
	
	
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
	 * @param unknown $id_int
	 * @param unknown $name_str
	 */
    public static function instanciate($id_mixed, $name_str, $dbprofile_str, $description_str)
    {
        self::checkID($id_mixed)? $id = intval($id_mixed,10) : $id = null ;
        
        //if( $id == null) return null;
        
        
    	$o = new Role();
        $o->_id = $id ;
        $o->_name = self::checkName($name_str)? $name_str : null ;
        $o->_dbprofile = is_string($dbprofile_str)? $dbprofile_str : null;
        $o->_description = is_string($description_str)? $description_str : null;
        
        return $o;
    }
	
	/**
	 * 
	 * @param unknown $name_str
	 */
	public static function checkName($name_str)
	{
		return Check::specificPureText($name_str,'/_',true,true,100);
	}

	
	/**
	 *
	 * @param unknown $name_str
	 */
	public static function checkDescription($description_str)
	{
	    if( $description_str !== null){
	        return Check::litteralI18nText($description_str,1000,'._,;-');       
	    }
	    else{
	        return true;
	    }
	}
	
	
	/**
	 *
	 * @param unknown $id_int
	 */
	public static function IDexists($id_mixed)
	{
	    self::checkID($id_mixed)? $id = intval($id_mixed,10) : $id = null ;
		
		if( $id == null) return false;
	    
	
	    $db = DbManager::getConnexion('internals/rbac_manager');
	     
	    $result = $db->SQL('SELECT `ROL_NAME` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'` WHERE ROL_ID = ?',array($id));
	     
	    if( count($result) == 1){
	        return true;
	    }
	    else{
	        return false;
	    }
	}
	
	
	/**
	 * get role by roleID
	 * 
	 * 
	 * @param unknown $id_int
	 * @throws InvalidFieldRoleException
	 * @throws RoleNotExistException
	 */
	public static function getByID($id_mixed)
	{
	    self::checkID($id_mixed)? $id = intval($id_mixed,10) : $id = null ;
		
		if( $id == null){
		    throw new RoleIDInvalidException('Role::getByID()',"ERROR: Role ID is invalid");
		    return null;
		}

		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$result = $db->SQL('SELECT `ROL_NAME`,`ROL_DB_PROFILE`,`ROL_DESCRIPTION` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'` WHERE `ROL_ID` = ?',array($id));
		
		if( count($result) == 1){	
		    
		    if( self::checkName($result[0]['ROL_NAME'])){
		        
		    	return self::instanciate($id,$result[0]['ROL_NAME'],$result[0]['ROL_DB_PROFILE'],$result[0]['ROL_DESCRIPTION']);
		    }
		    else{
		    	throw new CorruptedDataException("ERROR: Corrupted Role name detected. Role ID : ".$id);
		    	return null;
		    }
		}
		else{
		    throw new RoleNotExistsException('Role::getByID()',"Role not exists");
		    return null;
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
	    $result = $db->SQL('SELECT `ROL_ID`, `ROL_NAME`,`ROL_DB_PROFILE`,`ROL_DESCRIPTION`
	        FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'`
	        WHERE `ROL_ID` IN ('.$marker.')', $params);
	
	    if( count($result) > 0){
	
	        $coll = array();
	        foreach($result as $row){
	            $coll[] = self::instanciate($row['ROL_ID'], $row['ROL_NAME'], $row['ROL_DB_PROFILE'], $row['ROL_DESCRIPTION']);
	        }
	        return $coll;
	    }
	    else{
	        return null;
	    }
	}
	
	
	/**
	 * get role by roleID
	 *
	 *
	 * @param unknown $id_int
	 * @throws InvalidFieldRoleException
	 * @throws RoleNotExistException
	 */
	public static function getByName($name_str)
	{
	    self::checkName($name_str)? $name = $name_str : $name = null ;
	
	    if( $name == null){
		    throw new RoleNameInvalidException('Role::getByName()',"ERROR: Role's name is invalid");
		    return null;
		}
	
	
	    $db = DbManager::getConnexion('internals/rbac_manager');
	
	    $result = $db->SQL('SELECT `ROL_ID`, `ROL_NAME`,`ROL_DB_PROFILE`,`ROL_DESCRIPTION` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'` WHERE `ROL_NAME` = ?',array($name));
	
	    if( count($result) == 1){
	
	        if( self::checkName($result[0]['ROL_NAME'])){
	            return self::instanciate($result[0]['ROL_ID'],$result[0]['ROL_NAME'],$result[0]['ROL_DB_PROFILE'],$result[0]['ROL_DESCRIPTION']);
	        }
	        else{
	            throw new CorruptedDataException("ERROR: Corrupted Role name detected. Role ID : ".$result[0]['ROL_ID']);
	            return null;
	        }
	    }
	    else{
	        throw new RoleNotExistsException('Role::getByName()',"ERROR: Role not exists");
	        return null;
	    }
	
	}
	
	
	/**
	 * get all existing roles
	 *
	 * @throws Exception\RolesException
	 */
	public static function getAll()
	{
	    $db = DbManager::getConnexion('internals/rbac_manager');
	    	
	    try{
	        $result = $db->SQL('SELECT `ROL_ID`,`ROL_NAME`,`ROL_DB_PROFILE`,`ROL_DESCRIPTION` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'`');
	
	        $coll = array();
	        foreach( $result as $row)
	        {
	            $rid = (int)$row['ROL_ID'];
	             
	            if( self::checkName($row['ROL_NAME']) 
	               && (self::checkName($row['ROL_DB_PROFILE']) || is_null($row['ROL_DB_PROFILE']))
	               && (self::checkDescription($row['ROL_DESCRIPTION']))){
	                
	                $coll[] =  self::instanciate($rid,$row['ROL_NAME'],$row['ROL_DB_PROFILE'],$row['ROL_DESCRIPTION']);
	            }
	            else{
	                throw new CorruptedDataException("ERROR: Corrupted Role name detected.");
	            }
	        }
	
	    }catch( \PDOException $e){
	        throw new RoleException('Role::getAll()','Get all failed. PDOException catched. Profile used : '.'internals/rbac_manager');
	        return false;
	    }
	
	    return $coll;
	}
	
	
	/**
	 * 
	 * @param unknown $name_str
	 * @return boolean|number
	 */
	public function newRole( $name_str, $dbprofilename_str, $description_str)
	{
		if( !self::checkName($name_str) || !self::checkName($dbprofilename_str) 
	        || !self::checkDescription($description_str)){
		    
			throw new InvalidFieldRoleException('Role::newRole()',"Invalid field format");
			return false;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$id = $db->SQL('INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'`(`ROL_ID`,`ROL_NAME`,`ROL_DB_PROFILE`,`ROL_DESCRIPTION`) 
		    VALUES (NULL,?,?,?)',array($name_str,$dbprofilename_str,$description_str));
		if( $id !== false){
		    $this->_name = $name_str;
		    $this->_dbprofile = $dbprofilename_str;
		    $this->_description = $description_str;
			return (int)$id;
		}
		else{
			return false;
		}
	}
	
	/**
	 * 
	 * @param Role $modified_obj
	 * @throws RoleException
	 * @throws InvalidFieldRoleException
	 * @return boolean
	 */
	public function update( Role $modified_obj)
	{
	    if( ($this->_id == null) || !($modified_obj instanceof Role)){
	        throw new RoleIDInvalidException('Role::update()',"Incorrect ID");
	        return false;
	    }
	    
	    $diff = array_diff_assoc($modified_obj->toArray(),$this->toArray());
	    
	    $str = ''; $flag = true; $param=array();
	    foreach( $diff as $ppt=>$val){
	        switch($ppt)
	        {
                case 'name':
                    if( self::checkName($val)){
                        $param[':namei'] = $val;
                        $str .= '`ROL_NAME` = :namei,';
                    }
                    else{
                        $flag = false;
                    }
                    break;
                case 'dbprofile':
                    if( self::checkName($val)){
                        $param[':dbprofilei'] = $val;
                        $str .= '`ROL_DB_PROFILE` = :dbprofilei,';
                    }
                    else{
                        $flag = false;
                    }
    	            break;
    	        case 'description':
    	            if( self::checkDescription($val)){
    	                $param[':descriptioni'] = $val;
    	                $str .= '`ROL_DESCRIPTION` = :descriptioni,';
    	            }
    	            else{
    	                $flag = false;
    	            }
    	            break;
	        }
	    }
	    $str = substr($str, 0, -1);
	    $param[':id'] = $this->_id;
	    
	    if( $flag == false){
	        throw new InvalidFieldRoleException('Role::update()',"Role update failed, invalid input");
	        return false;
	    }
	    
	    $db = DbManager::getConnexion('internals/rbac_manager');
	    $flag = $db->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'` SET '.$str.'  WHERE `ROL_ID` = :id', $param);
	    
	    
	    if( $flag !== false){
	        foreach( $param as $col=>$val){
	           if( $col !== ':id'){
	               $this->{substr($col,1,-1)} = $val;
	           }
	        }
	        return true;
	    }
	    else{
	        return false;
	    }
	}
	
	
	
	/**
	 * 
	 * @param unknown $name_str
	 * @throws InvalidFieldRoleException
	 * @return boolean|number
	 */
	public function changeName($name_str)
	{
	    if( $this->_id == null){
	        throw new RoleIDInvalidException('Role::changeName()',"Incorrect ID");
	        return false;
	    }
	    
		if( !self::checkName($name_str)){
			throw new InvalidFieldRoleException('Role::getByID()',"Role name update failed, invalid name");
			return false;
		}
		
		if($name_str == $this->_name){
		    return true;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$param = array($name_str,$this->_id);
		$flag = $db->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'` SET `ROL_NAME` = ?  WHERE ROL_ID = ?', $param);
	
		
		if( $flag !== false){
			$this->_name = $name_str;
			return true;
		}
		else{
			return false;
		}	
	}
	
	/**
	 * 
	 * @param unknown $name_str
	 * @throws InvalidFieldRoleException
	 * @return boolean|number
	 */
	public function changeDescription($name_str)
	{
	    if( $this->_id == null){
	        throw new RoleIDInvalidException('Role::changeName()',"Incorrect ID");
	        return false;
	    }
	    
	    if( !self::checkDescription($name_str)){
			throw new InvalidFieldRoleException('Role::getByID()',"Role description update failed, invalid description");
			return false;
		}

		if($name_str == $this->_description){
		    return true;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$param = array($name_str,$this->_id);
		$flag = $db->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'` SET `ROL_DESCRIPTION` = ?  WHERE ROL_ID = ?', $param);
	
		
		if( $flag !== false){
			$this->_description = $name_str;
			return true;
		}
		else{
			return false;
		}	
	}
	
	/**
	 *
	 * @param unknown $name_str
	 * @throws InvalidFieldRoleException
	 * @return boolean|number
	 */
	public function changeDbProfileName($name_str)
	{
	    if( $this->_id == null){
	        throw new RoleIDInvalidException('Role::changedbProfileName()',"Incorrect ID");
	        return false;
	    }
	    
	    if( !self::checkName($name_str)){
			throw new InvalidFieldRoleException('Role::changeDbProfileName()',"Role's DB profile update failed, invalid name");
			return false;
		}
	
		if($name_str == $this->_name){
		    return true;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
	
		$param = array($name_str,$this->_id);
		$flag = $db->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'` SET `ROL_DB_PROFILE` = ?  WHERE ROL_ID = ?', $param);
	
	
		if( $flag !== false){
			$this->_dbprofile = $name_str;
			return true;
		}
		else{
			return false;
		}
	}
	
	
	/**
	 * 
	 * @throws RoleException
	 * @return boolean
	 */
	public function deleteRole()
	{
		if( $this->countUserDepends() > 0){
			throw new RoleException('Role::deleteRole()',"Role can't be delete, users are attached. Role ID : ".$this->_id);
		}
		
		if( Authorization::deleteByRole($this)===false){
			return false;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		$db->getHandler()->beginTransaction();

		$res = $db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'` WHERE ROL_ID = ?',array($this->_id));
		
		$db->getHandler()->commit();
		if( $res === false){
			$db->getHandler()->rollBack();
			throw new RoleException('Role::deleteRole()',"Role delete failed. Role ID : ".$this->_id);
			return false;
		}
		else{
			return true;
		}
		
	}
	
	
	/**
	 * 
	 * @return boolean|number
	 */
	public function countUserDepends()
	{
	    if( is_null($this->_id)){
	        return false;
	    }
	    
	    $db = DbManager::getConnexion('internals/rbac_manager');
	    $res = $db->SQL('SELECT COUNT(*) AS NBR FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_USER_USR').'` WHERE ROL_ID = ?',array($this->_id));
	    
	    return (int)$res[0]['NBR'];
	}

	
	
	/**
	 * 
	 * @return Ambigous <number, NULL, unknown>|boolean
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
	 * @return Ambigous <\Ufo\RBAC\multitype:\Ufo\RBAC\Authorization, boolean, multitype:\Ufo\RBAC\Authorization >
	 */
	public function getAuthorizations()
	{
	    if( $this->_authorizations == null){
	        if( $this->_id !== null){
	            $this->_authorizations = Authorization::getFromRole($this);
	        }
	        else{
	            throw new RoleException('Role::getAuthorization()','ID is not set');
	            return null;
	        }
	    }
	    
	    return $this->_authorizations;
	} 
	
	/**
	 * 
	 * @param Operation $ope_obj
	 * @return boolean
	 */
	public function addAuthorization( $operation_obj)
	{		
	    if( $operation_obj instanceof OperationCategorie){

	        $opes = $operation_obj->getOperations();
	        $f = true;
	        foreach($opes as $ope){
	            $f = $f && Authorization::newAuthorization($this, $ope);
	        }
	        return (bool)$f;
	    }
	    elseif( $operation_obj instanceof Operation){
	        return Authorization::newAuthorization($this, $operation_obj);
	    }
	}
	
	/**
	 * 
	 * @param Operation $ope_obj
	 * @return boolean
	 */
	public function removeAuthorization( $operation_obj)
	{
		
		if( $operation_obj instanceof OperationCategorie){
		
		    $opes = $operation_obj->getOperations();
		    $f = true;
		    foreach($opes as $ope){
		        $f = $f && Authorization::removeAuthorization($this, $operation_obj);
		    }
		    return (bool)$f;
		}
		elseif( $operation_obj instanceof Operation){
		    return Authorization::removeAuthorization($this, $operation_obj);
		}
	}
	
    /**
	 * To synchronize authorizations
	 *
	 * If an authorized operation is not in the list, she's removed,
	 * else if an operation in the array is unauthorized, she's added
	 *
	 * @param unknown $authorized_operations_array
	 * @return boolean
	 */
	public function syncAuthorizations( $authorized_operations_array)
	{
	    if(!is_array($authorized_operations_array)){
	        return false;
	    }
	     
	    // init
	    $authIDs = array();
	    $newIDs = array();
	     
	    // preparation IDs
	    
	    $auth = $this->getAuthorizations();
	    
	    foreach($auth as $author){
	        $authOpe[] = $author->getOperation();
	        $authIDs[] = $author->getOperation()->getID();
	    }
	    foreach($authorized_operations_array as $new_author){
	        $newIDs[] = $new_author->getID();
	    }
	     
	    
	    // adding new authorizations
	    foreach($authorized_operations_array as $new_ope){
	        if(!in_array($new_ope->getID(), $authIDs)){
	            $this->addAuthorization($new_ope);
	        }
	    }
	     
	    // remove old authorizations
	    foreach($authOpe as $old_ope){
	        if(!in_array($old_ope->getID(), $newIDs)){
	            $this->removeAuthorization($old_ope);
	        }
	    }
	     
	    unset($newIDs,$authIDs,$old_ope,$new_ope);
	    return true;
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
	 */
	public function getDbProfileName()
	{
		return $this->_dbprofile;
	}

	/**
	 * 
	 */
	public function getDescription()
	{
	    return $this->_description;
	}
	
	/**
	 * 
	 * @param unknown $operationname_str
	 * @return boolean
	 */
	public function isAuthorized( $operationname_str)
	{
		$auth = $this->getAuthorizations();
		
		if( isset($auth[$operationname_str])){
			return true;
		}
		else{
			return false;
		}		
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
	public function toArray( $wrapper_array = array('id'=>'id','name'=>'name','dbprofile'=>'dbprofile','description'=>'description'))
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