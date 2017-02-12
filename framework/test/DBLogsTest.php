<?php
require_once 'tests/Log/Workers/DBLogs.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * DBLogs test case.
 */
class DBLogsTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var DBLogs
     */
    private $DBLogs;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated DBLogsTest::setUp()
        
        $this->DBLogs = new DBLogs(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated DBLogsTest::tearDown()
        $this->DBLogs = null;
        
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
     * Tests DBLogs->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated DBLogsTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->DBLogs->__construct(/* parameters */);
    }

    /**
     * Tests DBLogs->log()
     */
    public function testLog()
    {
        // TODO Auto-generated DBLogsTest->testLog()
        $this->markTestIncomplete("log test not implemented");
        
        $this->DBLogs->log(/* parameters */);
    }
}

