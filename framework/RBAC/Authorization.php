<?php

namespace Ufo\RBAC;

use Ufo\Db\Manager as DbManager;
use Ufo\RBAC\Operation as Operation;


class AuthorizationException extends \Exception {} 


/**
 * @package UFO
 * @author gb-michel
 */
class Authorization
{
    /**
     * @var Role Role of the authorization
     */
	private $_role = null;
	
	/**
	 * @var Operation Operation wich is allow by authorization
	 */
	private $_operation = null;
	
	
    /**
     * Usage :
     * // $role = Role::getByName('Doctor');
     * Authorization::deleteByRole($role);
     * 
     * This method use Transactionnal SQL, if an error occur else the method executes a rollback.
     * 
	 * @method boolean Delete all authorizations allowed to an Role
	 * @param Role $role_obj Role from which removes permissions
	 * @throws AuthorizationException 
	 * @return boolean Return TRUE if delete successful, else FALSE
	 * @version 0.9
	 * @since 09/01/2014
     */
	public static function deleteByRole( Role $role_obj)
	{
		if( $role_obj->getID() == false){
			throw new AuthorizationException("ERROR: deletion by role fail, Incorrect Role ID");
			return false;
		}
		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$dbh = $db->getHandler();
		$dbh->beginTransaction();
		
		$res = $db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('TJ_AUTHORIZATION_AUT').'` WHERE ROL_ID = ?',array($role_obj->getID()));
		$db->getHandler()->commit();
		
		if( $res === false){
			$dbh->rollBack();
			throw new AuthorizationException("ERROR: Authorization can't be remove. Rollback. Role ID : ".$role_obj->getID());
			return false;
		}
		else{
			return true;
		}
	}
	
	/**
	 * @method multitype:\Ufo\RBAC\Authorization |boolean Get list of authorizations from a role
	 * @param Role $role Role to use
	 * @return multitype:\Ufo\RBAC\Authorization |boolean Return a array of Authorization for this role, FALSE if error survain
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public static function getFromRole( Role $role_obj)
	{
		if( $role_obj->getID() == false){
			throw new AuthorizationException("ERROR: get by role fail, Incorrect Role ID");
			return false;
		}
		
	    $db = DbManager::getConnexion('internals/rbac_manager');
	    
	    $res = $db->SQL(
	        'SELECT AUTOR.`OPE_ID`, OPE.`OPE_TITLE`, OPE.`OPC_ID`, OPE.`OPE_DESCRIPTION`   
	        FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('TJ_AUTHORIZATION_AUT').'` AS AUTOR 
	           INNER JOIN `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_OPERATION_OPE').'` AS OPE ON AUTOR.OPE_ID = OPE.OPE_ID  
	        WHERE AUTOR.ROL_ID = ?'
	    ,array($role_obj->getID()));
	    
	    if( $res !== false){

	        $coll = array();
	        foreach( $res as $row){
	            $o = new Authorization();
	            $o->_operation = Operation::instanciate((int)$row['OPE_ID'], $row['OPE_TITLE'], $row['OPE_DESCRIPTION'], $row['OPC_ID']);
	            $o->_role = &$role_obj;
	            $coll[$row['OPE_TITLE']] = $o;
	        }
	        
	        return $coll;
	    }
	    else{
	        return true;
	    }
	}
	
	
	
	/**
	 * This method use Transactionnal SQL, if an error occur else the method executes a rollback.
	 * 
	 * @method boolean Delete all authorizations allowed to an Operation
	 * @param Operation $ope_obj Operation for which removes permissions
	 * @throws AuthorizationException 
	 * @return boolean Return TRUE if delete successful, else FALSE
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public static function deleteFromOperation( Operation $ope_obj)
	{		
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$dbh = $db->getHandler();
		$dbh->beginTransaction();
		
		$res = $db->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('TJ_AUTHORIZATION_AUT').'` WHERE OPE_ID = ?',array($ope_obj->getID()));
		$db->getHandler()->commit();
		if( $res === false){
			$dbh->rollBack();
			throw new AuthorizationException("ERROR: Authorization can't be remove. Rollback. Operation ID : ".$ope_obj->getID());
			return false;
		}
		else{
			return true;
		}
	}
	
	
	/**
	 * @method multitype:\Ufo\RBAC\Authorization |boolean Get list of allowed Authorization to an Operation
	 * @param Operation $ope_obj Operation 
	 * @return multitype:\Ufo\RBAC\Authorization |boolean
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public static function getFromOperation( Operation $ope_obj)
	{
		$db = DbManager::getConnexion('internals/rbac_manager');
		 
		$res = $db->SQL(
				'SELECT AUTOR.`ROL_ID`, ROL.`ROL_NAME`
	        FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('TJ_AUTHORIZATION_AUT').'` AS AUTOR
	           INNER JOIN `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_ROLE_ROL').'` AS ROL ON AUTOR.ROL_ID = ROL.ROL_ID
	        WHERE AUTOR.OPE_ID = ?'
				,array($ope_obj->getID()));
		 
		if( $res !== false){
	
			$coll = array();
			foreach( $res as $row){
				$o = new Authorization();
				$o->_role = Role::instanciate((int)$row['ROL_ID'], $row['ROL_NAME']);
				$o->_operation = &$ope_obj;
				$coll[$row['ROL_NAME']] = $o;
			}
			 
			return $coll;
		}
		else{
			return true;
		}
	}
	
	
	
	/**
	 * @method boolean Add new authorization
	 * @param Role $role_obj Role wich support authorization
	 * @param Operation $ope_obj Operation to allow for the Role
	 * @throws AuthorizationException
	 * @throws Exception
	 * @return boolean Return TRUE if add successful, else FALSE
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public static function newAuthorization( Role $role_obj, Operation $ope_obj)
	{	
		// check validity of Role ID and Operation ID
		if( $role_obj->getID() == false){
			throw new AuthorizationException("ERROR: add fail, Incorrect Role ID");
			return false;
		}
		
		if( $ope_obj->getID() == false){
			throw new AuthorizationException("ERROR: add fail, Incorrect Operation ID");
			return false;
		}
		
		// insert 
		$db = DbManager::getConnexion('internals/rbac_manager');
				
		$flag = $db->SQL(
			'INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('TJ_AUTHORIZATION_AUT').'`(`ROL_ID`,`OPE_ID`) 
			VALUES (?,?)'
		,array(
			$role_obj->getID(),
			$ope_obj->getID(),
		));
	
		if( $flag !== false){
			return true;
		}
		else{
			throw new \Exception("ERROR: Insertion failed");
			return false;
		}		
	}
	
	
	/**
	 * @method boolean Remove an authorization
	 * @param Role $role_obj Role of authorization to remove
	 * @param Operation $ope_obj Operation allow by authorization
	 * @throws AuthorizationException
	 * @throws Exception
	 * @return boolean Return TRUE if remove successful, else FALSE
	 */
	public static function removeAuthorization( Role $role_obj, Operation $ope_obj)
	{
		// check validity of Role ID and Operation ID
		if( $role_obj->getID() == false){
			throw new AuthorizationException("ERROR: add fail, Incorrect Role ID");
			return false;
		}
		
		if( $ope_obj->getID() == false){
			throw new AuthorizationException("ERROR: add fail, Incorrect Operation ID");
			return false;
		}
		
		// remove
		$db = DbManager::getConnexion('internals/rbac_manager');
		
		$id = $db->SQL(
			'DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('TJ_AUTHORIZATION_AUT').'` WHERE (`ROL_ID`=?) AND (`OPE_ID`=?)'
			,array(
					$role_obj->getID(),
					$ope_obj->getID(),
			));
		
		if( $id !== false){
			return true;
		}
		else{
			throw new \Exception("ERROR: Deletion failed");
			return false;
		}
	}

	
	/**
	 * @method \Ufo\RBAC\Operation Get Operation of the authorization
	 * @return \Ufo\RBAC\Operation Operation if is set, else NULL
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public function getOperation()
	{
		return $this->_operation;
	}
	
	
	/**
	 * @method \Ufo\RBAC\Role Get Role of the authorization
	 * @return \Ufo\RBAC\Role Role if is set, else NULL
	 * @version 0.9
	 * @since 09/01/2014
	 */
	public function getRole()
	{
		return $this->_role;
	}
}

?>