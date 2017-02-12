<?php
require_once 'tests/User/User.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * User test case.
 */
class UserTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var User
     */
    private $User;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated UserTest::setUp()
        
        $this->User = new User(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UserTest::tearDown()
        $this->User = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }

    /**
     * Tests User::newUserObject()
     */
    public function testNewUserObject()
    {
        // TODO Auto-generated UserTest::testNewUserObject()
        $this->markTestIncomplete("newUserObject test not implemented");
        
        User::newUserObject(/* parameters */);
    }

    /**
     * Tests User::existingUserObject()
     */
    public function testExistingUserObject()
    {
        // TODO Auto-generated UserTest::testExistingUserObject()
        $this->markTestIncomplete("existingUserObject test not implemented");
        
        User::existingUserObject(/* parameters */);
    }

    /**
     * Tests User::forceLogin()
     */
    public function testForceLogin()
    {
        // TODO Auto-generated UserTest::testForceLogin()
        $this->markTestIncomplete("forceLogin test not implemented");
        
        User::forceLogin(/* parameters */);
    }

    /**
     * Tests User->getAccountCreationDate()
     */
    public function testGetAccountCreationDate()
    {
        // TODO Auto-generated UserTest->testGetAccountCreationDate()
        $this->markTestIncomplete("getAccountCreationDate test not implemented");
        
        $this->User->getAccountCreationDate(/* parameters */);
    }

    /**
     * Tests User->getUserID()
     */
    public function testGetUserID()
    {
        // TODO Auto-generated UserTest->testGetUserID()
        $this->markTestIncomplete("getUserID test not implemented");
        
        $this->User->getUserID(/* parameters */);
    }

    /**
     * Tests User::getPrimaryEmail()
     */
    public function testGetPrimaryEmail()
    {
        // TODO Auto-generated UserTest::testGetPrimaryEmail()
        $this->markTestIncomplete("getPrimaryEmail test not implemented");
        
        User::getPrimaryEmail(/* parameters */);
    }

    /**
     * Tests User::getUserIDFromEmail()
     */
    public function testGetUserIDFromEmail()
    {
        // TODO Auto-generated UserTest::testGetUserIDFromEmail()
        $this->markTestIncomplete("getUserIDFromEmail test not implemented");
        
        User::getUserIDFromEmail(/* parameters */);
    }

    /**
     * Tests User->verifyPassword()
     */
    public function testVerifyPassword()
    {
        // TODO Auto-generated UserTest->testVerifyPassword()
        $this->markTestIncomplete("verifyPassword test not implemented");
        
        $this->User->verifyPassword(/* parameters */);
    }

    /**
     * Tests User->resetPassword()
     */
    public function testResetPassword()
    {
        // TODO Auto-generated UserTest->testResetPassword()
        $this->markTestIncomplete("resetPassword test not implemented");
        
        $this->User->resetPassword(/* parameters */);
    }

    /**
     * Tests User->forceResetPassword()
     */
    public function testForceResetPassword()
    {
        // TODO Auto-generated UserTest->testForceResetPassword()
        $this->markTestIncomplete("forceResetPassword test not implemented");
        
        $this->User->forceResetPassword(/* parameters */);
    }

    /**
     * Tests User->deleteUser()
     */
    public function testDeleteUser()
    {
        // TODO Auto-generated UserTest->testDeleteUser()
        $this->markTestIncomplete("deleteUser test not implemented");
        
        $this->User->deleteUser(/* parameters */);
    }

    /**
     * Tests User->isPasswordExpired()
     */
    public function testIsPasswordExpired()
    {
        // TODO Auto-generated UserTest->testIsPasswordExpired()
        $this->markTestIncomplete("isPasswordExpired test not implemented");
        
        $this->User->isPasswordExpired(/* parameters */);
    }

    /**
     * Tests User::lockAccount()
     */
    public function testLockAccount()
    {
        // TODO Auto-generated UserTest::testLockAccount()
        $this->markTestIncomplete("lockAccount test not implemented");
        
        User::lockAccount(/* parameters */);
    }

    /**
     * Tests User::unlockAccount()
     */
    public function testUnlockAccount()
    {
        // TODO Auto-generated UserTest::testUnlockAccount()
        $this->markTestIncomplete("unlockAccount test not implemented");
        
        User::unlockAccount(/* parameters */);
    }

    /**
     * Tests User::isLocked()
     */
    public function testIsLocked()
    {
        // TODO Auto-generated UserTest::testIsLocked()
        $this->markTestIncomplete("isLocked test not implemented");
        
        User::isLocked(/* parameters */);
    }

    /**
     * Tests User::activateAccount()
     */
    public function testActivateAccount()
    {
        // TODO Auto-generated UserTest::testActivateAccount()
        $this->markTestIncomplete("activateAccount test not implemented");
        
        User::activateAccount(/* parameters */);
    }

    /**
     * Tests User->deactivateAccount()
     */
    public function testDeactivateAccount()
    {
        // TODO Auto-generated UserTest->testDeactivateAccount()
        $this->markTestIncomplete("deactivateAccount test not implemented");
        
        $this->User->deactivateAccount(/* parameters */);
    }

    /**
     * Tests User::isInactive()
     */
    public function testIsInactive()
    {
        // TODO Auto-generated UserTest::testIsInactive()
        $this->markTestIncomplete("isInactive test not implemented");
        
        User::isInactive(/* parameters */);
    }

    /**
     * Tests User::enableRememberMe()
     */
    public function testEnableRememberMe()
    {
        // TODO Auto-generated UserTest::testEnableRememberMe()
        $this->markTestIncomplete("enableRememberMe test not implemented");
        
        User::enableRememberMe(/* parameters */);
    }

    /**
     * Tests User::checkRememberMe()
     */
    public function testCheckRememberMe()
    {
        // TODO Auto-generated UserTest::testCheckRememberMe()
        $this->markTestIncomplete("checkRememberMe test not implemented");
        
        User::checkRememberMe(/* parameters */);
    }

    /**
     * Tests User::deleteAuthenticationToken()
     */
    public function testDeleteAuthenticationToken()
    {
        // TODO Auto-generated UserTest::testDeleteAuthenticationToken()
        $this->markTestIncomplete("deleteAuthenticationToken test not implemented");
        
        User::deleteAuthenticationToken(/* parameters */);
    }

    /**
     * Tests User::isUserIDValid()
     */
    public function testIsUserIDValid()
    {
        // TODO Auto-generated UserTest::testIsUserIDValid()
        $this->markTestIncomplete("isUserIDValid test not implemented");
        
        User::isUserIDValid(/* parameters */);
    }

    /**
     * Tests User->setRole()
     */
    public function testSetRole()
    {
        // TODO Auto-generated UserTest->testSetRole()
        $this->markTestIncomplete("setRole test not implemented");
        
        $this->User->setRole(/* parameters */);
    }

    /**
     * Tests User->getRole()
     */
    public function testGetRole()
    {
        // TODO Auto-generated UserTest->testGetRole()
        $this->markTestIncomplete("getRole test not implemented");
        
        $this->User->getRole(/* parameters */);
    }
}

