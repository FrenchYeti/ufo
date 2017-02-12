<?php
require_once 'UFO/Db/Manager.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Manager test case.
 */
class ManagerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Manager
     */
    private $Manager;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated ManagerTest::setUp()
        
        $this->Manager = new Manager(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ManagerTest::tearDown()
        $this->Manager = null;
        
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
     * Tests Manager::getInstance()
     */
    public function testGetInstance()
    {
        // TODO Auto-generated ManagerTest::testGetInstance()
        $this->markTestIncomplete("getInstance test not implemented");
        
        Manager::getInstance(/* parameters */);
    }

    /**
     * Tests Manager->issetConnexion()
     */
    public function testIssetConnexion()
    {
        // TODO Auto-generated ManagerTest->testIssetConnexion()
        $this->markTestIncomplete("issetConnexion test not implemented");
        
        $this->Manager->issetConnexion(/* parameters */);
    }

    /**
     * Tests Manager::getConnexion()
     */
    public function testGetConnexion()
    {
        // TODO Auto-generated ManagerTest::testGetConnexion()
        $this->markTestIncomplete("getConnexion test not implemented");
        
        Manager::getConnexion(/* parameters */);
    }

    /**
     * Tests Manager->getProfile()
     */
    public function testGetProfile()
    {
        // TODO Auto-generated ManagerTest->testGetProfile()
        $this->markTestIncomplete("getProfile test not implemented");
        
        $this->Manager->getProfile(/* parameters */);
    }

    /**
     * Tests Manager->setDefaultProfile()
     */
    public function testSetDefaultProfile()
    {
        // TODO Auto-generated ManagerTest->testSetDefaultProfile()
        $this->markTestIncomplete("setDefaultProfile test not implemented");
        
        $this->Manager->setDefaultProfile(/* parameters */);
    }
}

