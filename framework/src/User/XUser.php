<?php
namespace Ufo\User;

use Ufo\Db\Manager as DbManager;

/**
 * 
 * @author gbmichel
 *
 */
class XUser extends User
{
	
	
	
	/**
	 * First name of the user
	 * @var string
	 */
	protected $firstName = NULL;
	
	
	
	/**
	 * Last name of the user
	 * @var string
	 */
	protected $lastName = NULL;
	
	
	
	/**
	 * Secondary email of the user
	 * @var string
	 */
	protected $secondaryEmail = NULL;
	
	
	
	/**
	 * Date of Birth of the user
	 * @var int
	 */
	protected $dob = NULL;
	
	
	
	/**
	 * Minimum age that is required for all users
	 * @var int
	 */
	protected static $minAge = 378684000;	//12 years.
	
	
	
	/**
	 * Constructor of this class.
	 * @param \phpsec\User $userObj		The object of class \phpsec\User
	 */
	public function __construct($userObj)
	{
		$this->userID = $userObj->getUserID();
		
		if (! XUser::isXUserExists($this->userID))	//If user's records are not present in the DB, then insert them
			DbManager::getConnexion('internals/users_manager')->SQL('INSERT INTO `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_XUSER_XSR').'` (`USR_ID`) VALUES (?)', array($this->userID));
	}
	
	
	
	/**
	 * To check if the user's record are present in the DB or not.
	 * @param string $userID	The userID of the user
	 * @return boolean		Returns true if the user is present. False otherwise
	 */
	protected static function isXUserExists($userID)
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT USR_ID FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_XUSER_XSR').'` WHERE USR_ID = ?', array($userID));
		return (count($result) == 1);
	}
	
	
	
	/**
	 * To set the first name and last name of the user
	 * @param string $firstName	The first name of the user
	 * @param string $lastName	The last name of the user
	 */
	public function setName($firstName, $lastName)
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		
		DbManager::getConnexion('internals/users_manager')->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_XUSER_XSR').'` SET `XSR_FIRST_NAME` = ?, `XSR_LAST_NAME` = ? WHERE USR_ID = ?', array($this->firstName, $this->lastName, $this->userID));
	}
	
	
	
	/**
	 * To set the secondary email of the user
	 * @param string $secondaryEmail	The secondary email of the user
	 */
	public function setSecondaryEmail($secondaryEmail)
	{
		$this->secondaryEmail = $secondaryEmail;
		
		DbManager::getConnexion('internals/users_manager')->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_XUSER_XSR').'` SET `XSR_S_EMAIL` = ? WHERE USR_ID = ?', array($this->secondaryEmail, $this->userID));
	}
	
	
	
	/**
	 * To set the DOB of the user
	 * @param int $dob	The DOB of the user
	 */
	public function setDOB($dob)
	{
		$dob = (int)$dob;
		
		if ( $dob < time() )	//The given DOB is in past because DOB's cant be in future
		{
			$this->dob = $dob;
			DbManager::getConnexion('internals/users_manager')->SQL('UPDATE `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_XUSER_XSR').'` SET `XSR_DOB` = ? WHERE USR_ID = ?', array($this->dob, $this->userID));
		}
	}
	
	
	
	/**
	 * TO check if the age of the user satisfies the age criteria
	 * @return boolean	Returns true if the age is greater than the minimum age. False otherwise
	 */
	public function ageCheck()
	{
		$result = DbManager::getConnexion('internals/users_manager')->SQL('SELECT `XSR_DOB` FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_XUSER_XSR').'` WHERE USR_ID = ?', array($this->userID));
		
		if ( (\Ufo\Core\Init\time() - $result[0]['XSR_DOB']) < XUser::$minAge )
			return FALSE;

		return TRUE;
	}
	
	
	
	/**
	 * To delete the current user's record from the DB
	 */
	public function deleteXUser()
	{
		DbManager::getConnexion('internals/users_manager')->SQL('DELETE FROM `'._UFO_RBAC_SCHEMA_.'`.`'.\Ufo\Db\Manager::getConnexion('internals/users_manager')->manageCase('T_XUSER_XSR').'` WHERE USR_ID = ?', array(  $this->userID));
	}
}