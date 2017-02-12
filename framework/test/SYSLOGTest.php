<?php
require_once 'tests/Log/Workers/SYSLOG.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * SYSLOG test case.
 */
class SYSLOGTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var SYSLOG
     */
    private $SYSLOG;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated SYSLOGTest::setUp()
        
        $this->SYSLOG = new SYSLOG(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated SYSLOGTest::tearDown()
        $this->SYSLOG = null;
        
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
     * Tests SYSLOG->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated SYSLOGTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->SYSLOG->__construct(/* parameters */);
    }

    /**
     * Tests SYSLOG->log()
     */
    public function testLog()
    {
        // TODO Auto-generated SYSLOGTest->testLog()
        $this->markTestIncomplete("log test not implemented");
        
        $this->SYSLOG->log(/* parameters */);
    }
}

