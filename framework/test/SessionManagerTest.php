<?php
require_once 'tests/Session/SessionManager.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * SessionManager test case.
 */
class SessionManagerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var SessionManager
     */
    private $SessionManager;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated SessionManagerTest::setUp()
        
        $this->SessionManager = new SessionManager(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated SessionManagerTest::tearDown()
        $this->SessionManager = null;
        
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
     * Tests SessionManager::getInstance()
     */
    public function testGetInstance()
    {
        // TODO Auto-generated SessionManagerTest::testGetInstance()
        $this->markTestIncomplete("getInstance test not implemented");
        
        SessionManager::getInstance(/* parameters */);
    }

    /**
     * Tests SessionManager->__sleep()
     */
    public function test__sleep()
    {
        // TODO Auto-generated SessionManagerTest->test__sleep()
        $this->markTestIncomplete("__sleep test not implemented");
        
        $this->SessionManager->__sleep(/* parameters */);
    }

    /**
     * Tests SessionManager::isSessionOpened()
     */
    public function testIsSessionOpened()
    {
        // TODO Auto-generated SessionManagerTest::testIsSessionOpened()
        $this->markTestIncomplete("isSessionOpened test not implemented");
        
        SessionManager::isSessionOpened(/* parameters */);
    }

    /**
     * Tests SessionManager::newSession()
     */
    public function testNewSession()
    {
        // TODO Auto-generated SessionManagerTest::testNewSession()
        $this->markTestIncomplete("newSession test not implemented");
        
        SessionManager::newSession(/* parameters */);
    }

    /**
     * Tests SessionManager::destroySession()
     */
    public function testDestroySession()
    {
        // TODO Auto-generated SessionManagerTest::testDestroySession()
        $this->markTestIncomplete("destroySession test not implemented");
        
        SessionManager::destroySession(/* parameters */);
    }

    /**
     * Tests SessionManager->destroyAllSession()
     */
    public function testDestroyAllSession()
    {
        // TODO Auto-generated SessionManagerTest->testDestroyAllSession()
        $this->markTestIncomplete("destroyAllSession test not implemented");
        
        $this->SessionManager->destroyAllSession(/* parameters */);
    }

    /**
     * Tests SessionManager::getSession()
     */
    public function testGetSession()
    {
        // TODO Auto-generated SessionManagerTest::testGetSession()
        $this->markTestIncomplete("getSession test not implemented");
        
        SessionManager::getSession(/* parameters */);
    }

    /**
     * Tests SessionManager::storeIn()
     */
    public function testStoreIn()
    {
        // TODO Auto-generated SessionManagerTest::testStoreIn()
        $this->markTestIncomplete("storeIn test not implemented");
        
        SessionManager::storeIn(/* parameters */);
    }

    /**
     * Tests SessionManager::importFrom()
     */
    public function testImportFrom()
    {
        // TODO Auto-generated SessionManagerTest::testImportFrom()
        $this->markTestIncomplete("importFrom test not implemented");
        
        SessionManager::importFrom(/* parameters */);
    }
}

