<?php
namespace Ufo\User;

use Ufo\Security\BasicPasswordManagement;
use Ufo\Db\Manager as DbManager;
use Ufo\RBAC\Role as Role;


class UserException extends \Ufo\Error\StandardException
{   
    public function __construct( $calledmethod_str = '', $message_str = '', $code = 2)
    {
        parent::__construct('Ufo\User\User',' 
            -- On : <i>'.$calledmethod_str.'</i> <br>
            -- Exception caught : <i>'.get_class($this).'</i> <br>
            -- Message : <i>'.$message_str.'</i><br>
            -- File : '.$this->getFile().' at line : '.$this->getLine().'<br>
        ', $code);
    }
}


/**
 * Child Exception Classes
 */
class WrongPasswordException extends UserException {}			//The password provided for the existing user is not correct.
class UserExistsException extends UserException {}			//User already exists in the database.
class UserNotExistsException extends UserException {}			//User does not exists in the database.
class UserLocked extends UserException {}				//User account is locked.
class UserAccountInactive extends UserException {}			//User account is inactive.
class UserIDInvalid extends UserException {}			// Invalid User ID ( It could be null, empty, it's length outside limit, use forbidden chars)
class UserRoleNotExistsException extends UserException {}


class User extends BasicPasswordManagement
{
	/**
	 * 
	 * @var Role
	 */
	private $_role = null;
	
	/**
	 * ID of the user.
	 * @var string
	 */
	protected $userID = null;
	
	/**
	 * ID of the role of user
	 * @var int
	 */
	protected $roleID = null;
	
	
	/**
	 * Primary email of the user.
	 * @var string
	 */
	protected $primaryEmail = null;
	
	
	
	/**
	 * Hashing algorithm used for this user.
	 * @var string
	 */
	protected $hashAlgorithm = null;
	
	
	
	/**
	 * Hash of the user password.
	 * @var string
	 */
	private $hashedPassword = "";
	
	
	
	/**
	 * Dynamic salt used in creating the hash of the password.
	 * @var string
	 */
	private $dynamicSalt = "";
	
	
	
	/**
	 * Time after which a password must expire i.e. the password needs to be updated.
	 * @var int
	 */
	public static $passwordExpiryTime = 15552000;	//approx 6 months.
	
	
	
	/**
	 * Maximum time after which the user must re-login.
	 * @var int
	 */
	public static $rememberMeExpiryTime = 2592000;	//approx 1 month.
	
	
	/**
	 * Minimum number of chars allowed for UserID, should not exceed the table definition
	 * @var int
	 */
	public static $minUserIDNChars = 4;
	
	
	
	/**
	 * Maximum number of chars allowed for UserID, should match table definition
	 * @var int
	 */
	public static $maxUserIDNChars = 32;
	
	
	/**
	 * To create an object for a new user.
	 * @param string $id		The desired ID of the user
	 * @param string $pass		The desired password of the user
	 * @param string $pemail	The desired email of the user
	 * @throws UserExistsException	Will be thrown if the user already exists in the DB
	 * @throws UserIDInvalid	Will be thrown if the user ID Invalid ( It could be null, empty, it's length outside limit, use forbidden chars)
	 */
	public static function newUserObject($id, $pass, $pemail)
	{
		$obj = new User();	//create a new user object

		if (!User::isUserIDValid($id))
		    throw new UserIDInvalid('User::newUserObject()',"User ID is invalid.");
		
		$obj->userID = $id;		//set userID
		$obj->primaryEmail = $pemail;	//set primary email
			
		
		$time = \Ufo\Core\Init\time();

		//calculate the hash of the password.
		$obj->dynamicSalt = hash(BasicPasswordManagement::$hashAlgo, \Ufo\Core\Init\randstr(128));
		$obj->hashedPassword = BasicPasswordManagement::hashPassword($pass, $obj->dynamicSalt, BasicPasswordManagement::$hashAlgo);
		$obj->hashAlgorithm = BasicPasswordManagement::$hashAlgo;
		
		$count = DbManager::getConnexion('internals/users_manager')->SQL('INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`'.DbManager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` (`USR_ID`, `USR_P_EMAIL`, `USR_ACCOUNT_CREATED`, `USR_HASH`, `USR_DATE_CREATED`, `USR_ALGO`, `USR_DYNAMIC_SALT`) VALUES (?, ?, ?, ?, ?, ?, ?)', array($obj->userID, $obj->primaryEmail, $time, $obj->hashedPassword, $time, BasicPasswordManagement::$hashAlgo, $obj->dynamicSalt));

		//If the user is already present in the database, then a duplicate won't be created and no rows will be affected. Hence 0 will be returned.
		if ($count == 0){
			throw new UserExistsException('User::newUserObject()',"This User already exists in the DB.");
		}
	}
	
	
	
	/**
	 * To get the object of an existing user.
	 * @param string $id		The id of the user
	 * @param string $pass		The password of the user
	 * @return \phpsec\User		The object of the user that enables them to use other functions
	 * @throws UserNotExistsException	Will be thrown if no user is found with the given ID
	 * @throws WrongPasswordException	Will be thrown if the given password does not matches the old password stored in the DB
	 */
	public static function existingUserObject($id, $pass)
	{
		$obj = new User();
		
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT `USR_P_EMAIL`, `USR_HASH`, `USR_ALGO`, `USR_DYNAMIC_SALT`, `ROL_ID` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE `USR_ID` = ?', array($id));

		//If no record is returned for this user, then this user does not exist in the system.
		if (count($result) != 1)
			throw new UserNotExistsException('User::existingUserObject',"User Not found.");

		//validate the given password with that stored in the DB.
		if ( ! BasicPasswordManagement::validatePassword( $pass, $result[0]['USR_HASH'], $result[0]['USR_DYNAMIC_SALT'], $result[0]['USR_ALGO']))
			throw new WrongPasswordException('existingUserObject()',"Wrong Password.");
		
		//check if the user account is locked
		if (User::isLocked($id))
		{
			throw new UserLocked('User::existingUserObject()',"The account is locked!");
		}
		
		//check if the user account is inactive
		if (User::isInactive($id))
		{
			throw new UserAccountInactive('User::existingUserObject()',"The account is inactive. Please activate your account.");
		}
		
		//If all goes right, then set the local variables and return the user object.
		$obj->userID = $id;
		$obj->primaryEmail = $result[0]['USR_P_EMAIL'];
		$obj->dynamicSalt = $result[0]['USR_DYNAMIC_SALT'];
		$obj->hashedPassword = $result[0]['USR_HASH'];
		$obj->hashAlgorithm = $result[0]['USR_ALGO'];
		$obj->roleID = $result[0]['ROL_ID'];

		return $obj;
	}
	
	
	
	/**
	 * Function to provide userObject forcefully (i.e. without password).
	 * @param string $userID		The id of the user
	 * @return \phpsec\User			The object of the user that enables them to use other functions
	 * @throws UserNotExistsException	Will be thrown if no user is found with the given ID
	 */
	public static function forceLogin($id)
	{
		$obj = new User();
		
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT `USR_P_EMAIL`, `USR_HASH`, `USR_ALGO`, `USR_DYNAMIC_SALT`, `ROL_ID` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE `USR_ID` = ?', array($id));

		//If no record is returned for this user, then this user does not exist in the system.
		if (count($result) != 1)
			throw new UserNotExistsException('User::forceLogin()',"User Not found.");
		
		$obj->userID = $id;
		$obj->primaryEmail = $result[0]['USR_P_EMAIL'];
		$obj->dynamicSalt = $result[0]['USR_DYNAMIC_SALT'];
		$obj->hashedPassword = $result[0]['USR_HASH'];
		$obj->hashAlgorithm = $result[0]['USR_ALGO'];
		$obj->roleID = $result[0]['ROL_ID'];
		
		return $obj;
	}
	
	
	
	/**
	 * To get the date when the user account was created. The value returned is the UNIX timestamp.
	 * @return int
	 */
	public function getAccountCreationDate()
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT `USR_ACCOUNT_CREATED` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE USR_ID = ?', array($this->userID));
		return $result[0]['USR_ACCOUNT_CREATED'];
	}
	
	
	
	/**
	 * To get the userID of the current User.
	 * @return string
	 */
	public function getUserID()
	{
		return $this->userID;
	}
	
	
	
	/**
	 * To get the primary email of the user.
	 * @param string $userID		The id of the user whose email is required
	 * @return string | boolean		Returns the email of the user if the user is found. False otherwise
	 */
	public static function getPrimaryEmail($userID)
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT `USR_P_EMAIL` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE USR_ID = ?', array($userID));
		
		if (count($result) == 1)
		{
			return $result[0]['USR_P_EMAIL'];
		}
		
		return FALSE;
	}
	
	
	
	/**
	 * Function to return the userID that is associated with the provided email.
	 * @param string $email
	 * @return boolean	Returns the userID associated with the email. If MULTIPLE USERID or NO userID is associated, then returns FALSE
	 */
	public static function getUserIDFromEmail($email)
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT USR_ID FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE `USR_P_EMAIL` = ?', array($email));
		
		if (count($result) == 1)
		{
			return $result[0]['USR_ID'];
		}
		
		return FALSE;
	}
	
	
	
	/**
	 * To verify if a given string is the correct password that is stored in the DB for the current user.
	 * @param string $password	The password that is to be checked against the one stored in DB
	 * @return boolean		Returns True if the passwords match. False otherwise
	 */
	public function verifyPassword($password)
	{
		return BasicPasswordManagement::validatePassword($password, $this->hashedPassword, $this->dynamicSalt, $this->hashAlgorithm);
	}
	
	
	
	/**
	 * Function to reset the password for the current user.
	 * @param string $oldPassword		The old password of the user
	 * @param string $newPassword		The new desired password of the user
	 * @return boolean			Returns true if the password is reset successfully
	 * @throws WrongPasswordException	Throws if the old password does not matches the one stored in the DB
	 */
	public function resetPassword($oldPassword, $newPassword)
	{
		//If given password ($oldPassword) is not matched with the one stored in the DB.
		if (! BasicPasswordManagement::validatePassword( $oldPassword, $this->hashedPassword, $this->dynamicSalt, $this->hashAlgorithm))
			throw new WrongPasswordException("ERROR: Wrong Password provided!!");
		
		//create a new dynamic salt.
		$this->dynamicSalt = hash(BasicPasswordManagement::$hashAlgo, \Ufo\Core\Init\randstr(128));
		
		//create the hash of the new password.
		$newHash = BasicPasswordManagement::hashPassword($newPassword, $this->dynamicSalt, BasicPasswordManagement::$hashAlgo);
		
		//update the old password with the new password.
		DbManager::getConnexion('internals/users_manager')->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` SET `USR_HASH` = ?, `USR_DATE_CREATED` = ?, `USR_DYNAMIC_SALT` = ?, `USR_ALGO` = ? WHERE `USR_ID` = ?', array($newHash, time(), $this->dynamicSalt, BasicPasswordManagement::$hashAlgo, $this->userID));
		
		$this->hashedPassword = $newHash;
		$this->hashAlgorithm = BasicPasswordManagement::$hashAlgo;

		return TRUE;
	}
	
	
	
	/**
	 * Function to force to change the password, even when the user has not provided the old password for verification. Used with "forgot password controller".
	 * If the user forgets his password, they need to be validated using their primary email. Once that is done, the user would like to keep a new password. This function will help there to keep a new password.
	 * @param string $newPassword
	 * @return boolean	Returns TRUE when the password has been changed successfully
	 */
	public function forceResetPassword($newPassword)
	{
		//create a new dynamic salt.
		$this->dynamicSalt = hash(BasicPasswordManagement::$hashAlgo, \Ufo\Core\Init\randstr(128));
		
		//create the hash of the new password.
		$newHash = BasicPasswordManagement::hashPassword($newPassword, $this->dynamicSalt, BasicPasswordManagement::$hashAlgo);
		
		//update the old password with the new password.
		DbManager::getConnexion('internals/users_manager')->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` SET `USR_HASH` = ?, `USR_DATE_CREATED` = ?, `USR_DYNAMIC_SALT` = ?, `USR_ALGO` = ? WHERE `USR_ID` = ?', array($newHash, \Ufo\Core\Init\time(), $this->dynamicSalt, BasicPasswordManagement::$hashAlgo, $this->userID));
		
		$this->hashedPassword = $newHash;
		$this->hashAlgorithm = BasicPasswordManagement::$hashAlgo;

		return TRUE;
	}
	
	
	
	/**
	 * To delete the current user.
	 * @return boolean		Returns True if the user is deleted successfully
	 */
	public function deleteUser()
	{
		//Delete user Data from from Password Table.
		DbManager::getConnexion('internals/users_manager')->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_PASSWORD_PWD').'` WHERE USR_ID = ?', array($this->userID));
		
		//Delete user Data from from User Table.
		DbManager::getConnexion('internals/users_manager')->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE USR_ID = ?', array($this->userID));
		
		return TRUE;
	}
	
	
	
	/**
	 * To check if the password has aged. i.e. if the time has passed after which the password must be changed.
	 * @return boolean	Returns TRUE if the password HAS AGED. False if the password has NOT AGED
	 */
	public function isPasswordExpired()
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT `USR_DATE_CREATED` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE `USR_ID` = ?', array($this->userID));
			
		$currentTime = \Ufo\Core\Init\time();

		if ( ($currentTime - $result[0]['USR_DATE_CREATED'])  > User::$passwordExpiryTime)
			return TRUE;
		else
			return FALSE;
	}
	
	
	
	/**
	 * Function to lock the user account.
	 */
	public static function lockAccount($userID)
	{
		DbManager::getConnexion('internals/users_manager')->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` SET USR_LOCKED = ? WHERE USR_ID = ?', array(1, $userID));
	}
	
	
	
	/**
	 * Function to unlock the user account.
	 */
	public static function unlockAccount($userID)
	{
		DbManager::getConnexion('internals/users_manager')->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` SET USR_LOCKED = ? WHERE USR_ID = ?', array(0, $userID));
	}
	
	
	
	/**
	 * Function to check if the user account is locked or not.
	 * @param string $userID	The id of the user whose account status is being checked	
	 * @return boolean		Returns True if the account is locked. False otherwise
	 */
	public static function isLocked($userID)
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT USR_LOCKED FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE USR_ID = ?', array($userID));
		
		if (count($result) == 1)
		{
			if ($result[0]['USR_LOCKED'] == 1)
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	
	
	/**
	 * Function to activate the account
	 */
	public static function activateAccount($userID)
	{
		DbManager::getConnexion('internals/users_manager')->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` SET USR_INACTIVE = ? WHERE USR_ID = ?', array(0, $userID));
	}
	
	
	
	/**
	 * Function to deactivate the account
	 */
	public function deactivateAccount()
	{
		DbManager::getConnexion('internals/users_manager')->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` SET USR_INACTIVE = ? WHERE USR_ID = ?', array(1, $this->userID));
	}
	
	
	
	/**
	 * Function to check if the user's account is inactive or not.
	 * @param string $userID		The id of the user whose account status is being checked	
	 * @return boolean		Returns True if the account is inactive. False otherwise
	 */
	public static function isInactive($userID)
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT USR_INACTIVE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE USR_ID = ?', array($userID));
		
		if (count($result) == 1)
		{
			if ($result[0]['USR_INACTIVE'] == 1)
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	
	
	/**
	 * Function to enable "Remember Me" functionality.
	 * @param boolean $secure	//If set, the cookies will only set for HTTPS connections
	 * @param boolean $httpOnly	//If set, the cookies will only be accessible via HTTP Methods and not via Javascript and other means
	 * @return boolean		//Returns true if the function is enabled successfully
	 */
	public static function enableRememberMe($userID, $secure = TRUE, $httpOnly = TRUE)
	{
		$authID = \Ufo\Core\Init\randstr(128);	//create a new authentication token
			
		DbManager::getConnexion('internals/users_manager')->SQL('INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_AUTHTOKENS_ATK').'` (`ATK_ID`, `USR_ID`, `ATK_DATE_CREATED`) VALUES (?, ?, ?)', array($authID, $userID, time()));

		//store the newly created session into the user cookie.
		if ($secure && $httpOnly)
			\setcookie("AUTHID", $authID, \Ufo\Core\Init\time() + User::$rememberMeExpiryTime, null, null, TRUE, TRUE);
		elseif (!$secure && !$httpOnly)
			\setcookie("AUTHID", $authID, \Ufo\Core\Init\time() + User::$rememberMeExpiryTime, null, null, FALSE, FALSE);
		elseif ($secure && !$httpOnly)
			\setcookie("AUTHID", $authID, \Ufo\Core\Init\time() + User::$rememberMeExpiryTime, null, null, TRUE, FALSE);
		elseif (!$secure && $httpOnly)
			\setcookie("AUTHID", $authID, \Ufo\Core\Init\time() + User::$rememberMeExpiryTime, null, null, FALSE, TRUE);
		
		return TRUE;
	}
	
	
	
	/**
	 * Function to check for AUTH token validity.
	 * @return boolean	Return the userID related to the token if the AUTH token is valid. False otherwise
	 */
	public static function checkRememberMe()
	{
		if (isset($_COOKIE['AUTHID']))
		{
			//get the given AUTH token from the DB.
			$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT * FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_AUTHTOKENS_ATK').'` WHERE `ATK_ID` = ?', array($_COOKIE['AUTHID']->sanitizeWithCheck('pureText',true,false,128)));
			
			//If the AUTH token is found in DB
			if (count($result) == 1)
			{
				$currentTime = time();

				//If cookie time has expired, then delete the cookie from the DB and the user's browser.
				if ( ($currentTime - $result[0]['ATK_DATE_CREATED']) >= User::$rememberMeExpiryTime)
				{
					User::deleteAuthenticationToken();
					return FALSE;
				}
				else	//The AUTH token is correct and valid. Hence, return the userID related to this AUTH token
					return $result[0]['USR_ID'];
			}
			else	//If this AUTH token is not found in DB, then erase the cookie from the client's machine and return FALSE
			{
				\setcookie("AUTHID", "");
				return FALSE;
			}
		}
		else	//If the user is unable to provide a AUTH token, then return FALSE
			return FALSE;
	}
	
	
	
	/**
	 * Function to delete the current user authentication token from the DB and user cookies
	 */
	public static function deleteAuthenticationToken()
	{
		if (isset($_COOKIE['AUTHID']))
		{
			DbManager::getConnexion('internals/users_manager')->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_AUTHTOKENS_ATK').'` WHERE `ATK_ID` = ?', array($_COOKIE['AUTHID']->sanitizeWithCheck('pureText',true,false,128)));
			\setcookie("AUTHID", "");
		}
	}
	
	

	/**
	 * Function to check if a userID is elegible for use.
	 * Not allowed: null, empty, use char other than (A-Z 0-9 or _ @ . -),outside length limit
	 * @return boolean	Return True if UserID is ellegible. False otherwise
	 */
	public static function isUserIDValid($userID)
	{
		if ($userID == null || strlen($userID) < User::$minUserIDNChars || strlen($userID) > User::$maxUserIDNChars)
			return FALSE;
	
		return preg_match("/^[a-z0-9A-Z_@.-]*$/", $userID) == 1;
	}	
	
	
	
	/**
	 * Update Role of a user
	 * 
	 * @param unknown $role_obj
	 * @return boolean
	 */
	public function setRole( Role $role_obj)
	{
	   if( !($role_obj instanceof Role)){
	       return FALSE;
	   }    
	   
	   $db = DbManager::getConnexion('internals/users_manager');
	   
	   $f = $db->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.$db->manageCase('T_USER_USR').'` SET ROL_ID = ? WHERE USR_ID = ?', array($role_obj->getID(),$this->userID));
       if( $f === false) return FALSE;
	   
       $this->roleID = $role_obj->getID();
       $this->role = $role_obj;
	}
	
	
	/**
	 * Get role of current user 
	 */
	public function getRole()
	{
	    try{
            if( $this->_role == null){
                $this->_role = Role::getByID($this->roleID);
            }
            
            return $this->_role;
	    }
	    catch( \Ufo\RBAC\RoleNotExistsException $e){
	        
	        throw new UserRoleNotExistsException('User::getRole()',"Role of the user not exists");
	        return null;
	    }
    }
	
}

?>
