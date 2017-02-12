<?php
namespace Ufo\User;

use Ufo\Session\Session;
use Ufo\Db\Manager as DbManager;
use Ufo\RBAC\Role;

class UserManagement
{
	
	
	
	/**
	 * To check if given userID exists in the system or not.
	 * @param string $userID	The user ID that needs to be checked
	 * @return boolean		Returns true if the user exists. False otherwise
	 */
	public static function userExists($userID)
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT USR_ID FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE USR_ID = ?', array($userID));
		return (count($result) == 1);
	}
	
	
	
	/**
	 * To create a new user.
	 * @param string $userID		The desired ID of the user
	 * @param string $password		The password of the user
	 * @param string $email			The primary email of the user
	 * @return boolean			Returns if the user is created. False otherwise
	 * @throws UserExistsException		Will be thrown if the user already exists in the DB
	 * @throws UserIDInvalid	Will be thrown if the user ID Invalid ( It could be null, empty, it's length outside limit, use forbidden chars)
	 */
	public static function createUser($userID, $password, $email, $role = null)
	{
		if (! UserManagement::userExists( $userID ))	//If the user is not in the system, create a new user.
		{
			User::newUserObject($userID, $password, $email);
			
			if( ($role !== null) && ($role instanceof Role)){
			    $user = User::forceLogin($userID);
			    $user->setRole($role);
			}
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	
	/**
	 * To delete a user.	
	 * @param string $userID		The user ID that needs to be deleted
	 * @return boolean			Returns true if the user is deleted. False 
	 * @throws UserNotExistsException	Will be thrown if no user is found with the given ID
	 */
	public static function deleteUser($userID)
	{
		$userObj = UserManagement::forceLogIn($userID);
		$deleted = $userObj->deleteUser();
		
		return ($deleted == TRUE);
	}
	
	
	
	/**
	 * To return the total number of users in the system.
	 * @return int		Total users
	 */
	public static function userCount()
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT USR_ID FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_USER_USR').'` WHERE 1', array());
		return count($result);
	}
	
	
	
	/**
	 * Function for user to log-in.
	 * @param string $userID	The user ID that wants to log in
	 * @param string $password	Password to login
	 * @return \phpsec\User		Returns the user object
	 * @throws UserNotExistsException	Will be thrown if no user is found with the given ID
	 * @throws WrongPasswordException	Will be thrown if the given password does not matches the old password stored in the DB
	 */
	public static function logIn($userID, $password)
	{
		return User::existingUserObject($userID, $password);	//If any user credential is wrong, exception will be thrown.
	}
	
	
	
	/**
	 * Function for user to log-in forcefully i.e without providing user-credentials.
	 * @param string $userID		The user ID that needs to log in
	 * @return \phpsec\User			Returns the user object
	 * @throws UserNotExistsException	Will be thrown if no user is found with the given ID
	 */
	public static function forceLogIn($userID)
	{
		return User::forceLogin($userID);
	}
	
	
	
	/**
	 * Function for user to Log-out.
	 * @param \phpsec\User $userObj		The user object of the user that needs to log out
	 */
	public static function logOut($userObj)
	{
		if ($userObj->checkRememberMe() === $userObj->getUserID())
		{
			User::deleteAuthenticationToken();	//delete the authentication token from the server and the user's browser
		}
		
		$tempSession = new Session();
		$tempSession->existingSession();
		$tempSession->destroySession();
	}
	
	
	
	/**
	 * Function for user to log-out from all the devices at once.
	 * @param string $userID	The user ID that needs to log out from all devices
	 */
	public static function logOutFromAllDevices($userID)
	{
		DbManager::getConnexion('internals/users_manager')->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_AUTHTOKENS_ATK').'` WHERE USR_ID = ?', array($userID));
		Session::destroyAllSessions($userID);
	}
}

?>