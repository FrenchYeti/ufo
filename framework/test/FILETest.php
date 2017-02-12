<?php
require_once 'tests/Log/Workers/FILE.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * FILE test case.
 */
class FILETest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var FILE
     */
    private $FILE;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated FILETest::setUp()
        
        $this->FILE = new FILE(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated FILETest::tearDown()
        $this->FILE = null;
        
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
     * Tests FILE->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated FILETest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->FILE->__construct(/* parameters */);
    }

    /**
     * Tests FILE->log()
     */
    public function testLog()
    {
        // TODO Auto-generated FILETest->testLog()
        $this->markTestIncomplete("log test not implemented");
        
        $this->FILE->log(/* parameters */);
    }
}

