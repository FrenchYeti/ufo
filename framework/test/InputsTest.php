<?php
require_once 'tests/HTTP/Inputs.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Inputs test case.
 */
class InputsTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Inputs
     */
    private $Inputs;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated InputsTest::setUp()
        
        $this->Inputs = new Inputs(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated InputsTest::tearDown()
        $this->Inputs = null;
        
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
     * Tests Inputs::init()
     */
    public function testInit()
    {
        // TODO Auto-generated InputsTest::testInit()
        $this->markTestIncomplete("init test not implemented");
        
        Inputs::init(/* parameters */);
    }

    /**
     * Tests Inputs::lock()
     */
    public function testLock()
    {
        // TODO Auto-generated InputsTest::testLock()
        $this->markTestIncomplete("lock test not implemented");
        
        Inputs::lock(/* parameters */);
    }

    /**
     * Tests Inputs::unlock()
     */
    public function testUnlock()
    {
        // TODO Auto-generated InputsTest::testUnlock()
        $this->markTestIncomplete("unlock test not implemented");
        
        Inputs::unlock(/* parameters */);
    }

    /**
     * Tests Inputs->get()
     */
    public function testGet()
    {
        // TODO Auto-generated InputsTest->testGet()
        $this->markTestIncomplete("get test not implemented");
        
        $this->Inputs->get(/* parameters */);
    }

    /**
     * Tests Inputs->offsetSet()
     */
    public function testOffsetSet()
    {
        // TODO Auto-generated InputsTest->testOffsetSet()
        $this->markTestIncomplete("offsetSet test not implemented");
        
        $this->Inputs->offsetSet(/* parameters */);
    }

    /**
     * Tests Inputs->offsetExists()
     */
    public function testOffsetExists()
    {
        // TODO Auto-generated InputsTest->testOffsetExists()
        $this->markTestIncomplete("offsetExists test not implemented");
        
        $this->Inputs->offsetExists(/* parameters */);
    }

    /**
     * Tests Inputs->offsetUnset()
     */
    public function testOffsetUnset()
    {
        // TODO Auto-generated InputsTest->testOffsetUnset()
        $this->markTestIncomplete("offsetUnset test not implemented");
        
        $this->Inputs->offsetUnset(/* parameters */);
    }

    /**
     * Tests Inputs->offsetGet()
     */
    public function testOffsetGet()
    {
        // TODO Auto-generated InputsTest->testOffsetGet()
        $this->markTestIncomplete("offsetGet test not implemented");
        
        $this->Inputs->offsetGet(/* parameters */);
    }
}

