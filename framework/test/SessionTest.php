<?php
require_once 'tests/Session/UFO_Session.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Session test case.
 */
class SessionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Session
     */
    private $Session;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated SessionTest::setUp()
        
        $this->Session = new Session(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated SessionTest::tearDown()
        $this->Session = null;
        
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
     * Tests Session::getInstance()
     */
    public function testGetInstance()
    {
        // TODO Auto-generated SessionTest::testGetInstance()
        $this->markTestIncomplete("getInstance test not implemented");
        
        Session::getInstance(/* parameters */);
    }

    /**
     * Tests Session::initialize()
     */
    public function testInitialize()
    {
        // TODO Auto-generated SessionTest::testInitialize()
        $this->markTestIncomplete("initialize test not implemented");
        
        Session::initialize(/* parameters */);
    }

    /**
     * Tests Session::restore()
     */
    public function testRestore()
    {
        // TODO Auto-generated SessionTest::testRestore()
        $this->markTestIncomplete("restore test not implemented");
        
        Session::restore(/* parameters */);
    }

    /**
     * Tests Session::exist()
     */
    public function testExist()
    {
        // TODO Auto-generated SessionTest::testExist()
        $this->markTestIncomplete("exist test not implemented");
        
        Session::exist(/* parameters */);
    }

    /**
     * Tests Session::isOpen()
     */
    public function testIsOpen()
    {
        // TODO Auto-generated SessionTest::testIsOpen()
        $this->markTestIncomplete("isOpen test not implemented");
        
        Session::isOpen(/* parameters */);
    }

    /**
     * Tests Session->reset()
     */
    public function testReset()
    {
        // TODO Auto-generated SessionTest->testReset()
        $this->markTestIncomplete("reset test not implemented");
        
        $this->Session->reset(/* parameters */);
    }

    /**
     * Tests Session->destroy()
     */
    public function testDestroy()
    {
        // TODO Auto-generated SessionTest->testDestroy()
        $this->markTestIncomplete("destroy test not implemented");
        
        $this->Session->destroy(/* parameters */);
    }

    /**
     * Tests Session->setData()
     */
    public function testSetData()
    {
        // TODO Auto-generated SessionTest->testSetData()
        $this->markTestIncomplete("setData test not implemented");
        
        $this->Session->setData(/* parameters */);
    }

    /**
     * Tests Session->removeData()
     */
    public function testRemoveData()
    {
        // TODO Auto-generated SessionTest->testRemoveData()
        $this->markTestIncomplete("removeData test not implemented");
        
        $this->Session->removeData(/* parameters */);
    }

    /**
     * Tests Session->getData()
     */
    public function testGetData()
    {
        // TODO Auto-generated SessionTest->testGetData()
        $this->markTestIncomplete("getData test not implemented");
        
        $this->Session->getData(/* parameters */);
    }

    /**
     * Tests Session->issetData()
     */
    public function testIssetData()
    {
        // TODO Auto-generated SessionTest->testIssetData()
        $this->markTestIncomplete("issetData test not implemented");
        
        $this->Session->issetData(/* parameters */);
    }

    /**
     * Tests Session->regenerateID()
     */
    public function testRegenerateID()
    {
        // TODO Auto-generated SessionTest->testRegenerateID()
        $this->markTestIncomplete("regenerateID test not implemented");
        
        $this->Session->regenerateID(/* parameters */);
    }
}

