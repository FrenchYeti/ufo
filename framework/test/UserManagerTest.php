<?php
require_once 'UFO/User/UserManager.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * UserManager test case.
 */
class UserManagerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var UserManager
     */
    private $UserManager;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated UserManagerTest::setUp()
        
        $this->UserManager = new UserManager(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UserManagerTest::tearDown()
        $this->UserManager = null;
        
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
     * Tests UserManager->__sleep()
     */
    public function test__sleep()
    {
        // TODO Auto-generated UserManagerTest->test__sleep()
        $this->markTestIncomplete("__sleep test not implemented");
        
        $this->UserManager->__sleep(/* parameters */);
    }

    /**
     * Tests UserManager::getInstance()
     */
    public function testGetInstance()
    {
        // TODO Auto-generated UserManagerTest::testGetInstance()
        $this->markTestIncomplete("getInstance test not implemented");
        
        UserManager::getInstance(/* parameters */);
    }

    /**
     * Tests UserManager::isOpen()
     */
    public function testIsOpen()
    {
        // TODO Auto-generated UserManagerTest::testIsOpen()
        $this->markTestIncomplete("isOpen test not implemented");
        
        UserManager::isOpen(/* parameters */);
    }

    /**
     * Tests UserManager::getDBProfile()
     */
    public function testGetDBProfile()
    {
        // TODO Auto-generated UserManagerTest::testGetDBProfile()
        $this->markTestIncomplete("getDBProfile test not implemented");
        
        UserManager::getDBProfile(/* parameters */);
    }

    /**
     * Tests UserManager::getUser()
     */
    public function testGetUser()
    {
        // TODO Auto-generated UserManagerTest::testGetUser()
        $this->markTestIncomplete("getUser test not implemented");
        
        UserManager::getUser(/* parameters */);
    }

    /**
     * Tests UserManager::getSession()
     */
    public function testGetSession()
    {
        // TODO Auto-generated UserManagerTest::testGetSession()
        $this->markTestIncomplete("getSession test not implemented");
        
        UserManager::getSession(/* parameters */);
    }

    /**
     * Tests UserManager::checkAuthorization()
     */
    public function testCheckAuthorization()
    {
        // TODO Auto-generated UserManagerTest::testCheckAuthorization()
        $this->markTestIncomplete("checkAuthorization test not implemented");
        
        UserManager::checkAuthorization(/* parameters */);
    }

    /**
     * Tests UserManager->setData()
     */
    public function testSetData()
    {
        // TODO Auto-generated UserManagerTest->testSetData()
        $this->markTestIncomplete("setData test not implemented");
        
        $this->UserManager->setData(/* parameters */);
    }

    /**
     * Tests UserManager::setUserData()
     */
    public function testSetUserData()
    {
        // TODO Auto-generated UserManagerTest::testSetUserData()
        $this->markTestIncomplete("setUserData test not implemented");
        
        UserManager::setUserData(/* parameters */);
    }

    /**
     * Tests UserManager->getData()
     */
    public function testGetData()
    {
        // TODO Auto-generated UserManagerTest->testGetData()
        $this->markTestIncomplete("getData test not implemented");
        
        $this->UserManager->getData(/* parameters */);
    }

    /**
     * Tests UserManager::getUserData()
     */
    public function testGetUserData()
    {
        // TODO Auto-generated UserManagerTest::testGetUserData()
        $this->markTestIncomplete("getUserData test not implemented");
        
        UserManager::getUserData(/* parameters */);
    }

    /**
     * Tests UserManager::start()
     */
    public function testStart()
    {
        // TODO Auto-generated UserManagerTest::testStart()
        $this->markTestIncomplete("start test not implemented");
        
        UserManager::start(/* parameters */);
    }

    /**
     * Tests UserManager::open()
     */
    public function testOpen()
    {
        // TODO Auto-generated UserManagerTest::testOpen()
        $this->markTestIncomplete("open test not implemented");
        
        UserManager::open(/* parameters */);
    }

    /**
     * Tests UserManager::close()
     */
    public function testClose()
    {
        // TODO Auto-generated UserManagerTest::testClose()
        $this->markTestIncomplete("close test not implemented");
        
        UserManager::close(/* parameters */);
    }
}

