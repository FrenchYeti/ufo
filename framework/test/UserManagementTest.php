<?php
require_once 'tests/User/UserManagement.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * UserManagement test case.
 */
class UserManagementTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var UserManagement
     */
    private $UserManagement;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated UserManagementTest::setUp()
        
        $this->UserManagement = new UserManagement(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UserManagementTest::tearDown()
        $this->UserManagement = null;
        
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
     * Tests UserManagement::userExists()
     */
    public function testUserExists()
    {
        // TODO Auto-generated UserManagementTest::testUserExists()
        $this->markTestIncomplete("userExists test not implemented");
        
        UserManagement::userExists(/* parameters */);
    }

    /**
     * Tests UserManagement::createUser()
     */
    public function testCreateUser()
    {
        // TODO Auto-generated UserManagementTest::testCreateUser()
        $this->markTestIncomplete("createUser test not implemented");
        
        UserManagement::createUser(/* parameters */);
    }

    /**
     * Tests UserManagement::deleteUser()
     */
    public function testDeleteUser()
    {
        // TODO Auto-generated UserManagementTest::testDeleteUser()
        $this->markTestIncomplete("deleteUser test not implemented");
        
        UserManagement::deleteUser(/* parameters */);
    }

    /**
     * Tests UserManagement::userCount()
     */
    public function testUserCount()
    {
        // TODO Auto-generated UserManagementTest::testUserCount()
        $this->markTestIncomplete("userCount test not implemented");
        
        UserManagement::userCount(/* parameters */);
    }

    /**
     * Tests UserManagement::logIn()
     */
    public function testLogIn()
    {
        // TODO Auto-generated UserManagementTest::testLogIn()
        $this->markTestIncomplete("logIn test not implemented");
        
        UserManagement::logIn(/* parameters */);
    }

    /**
     * Tests UserManagement::forceLogIn()
     */
    public function testForceLogIn()
    {
        // TODO Auto-generated UserManagementTest::testForceLogIn()
        $this->markTestIncomplete("forceLogIn test not implemented");
        
        UserManagement::forceLogIn(/* parameters */);
    }

    /**
     * Tests UserManagement::logOut()
     */
    public function testLogOut()
    {
        // TODO Auto-generated UserManagementTest::testLogOut()
        $this->markTestIncomplete("logOut test not implemented");
        
        UserManagement::logOut(/* parameters */);
    }

    /**
     * Tests UserManagement::logOutFromAllDevices()
     */
    public function testLogOutFromAllDevices()
    {
        // TODO Auto-generated UserManagementTest::testLogOutFromAllDevices()
        $this->markTestIncomplete("logOutFromAllDevices test not implemented");
        
        UserManagement::logOutFromAllDevices(/* parameters */);
    }
}

