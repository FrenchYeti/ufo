<?php
require_once 'tests/Log/Logger.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Logger test case.
 */
class LoggerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Logger
     */
    private $Logger;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated LoggerTest::setUp()
        
        $this->Logger = new Logger(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated LoggerTest::tearDown()
        $this->Logger = null;
        
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
     * Tests Logger->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated LoggerTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->Logger->__construct(/* parameters */);
    }

    /**
     * Tests Logger->log()
     */
    public function testLog()
    {
        // TODO Auto-generated LoggerTest->testLog()
        $this->markTestIncomplete("log test not implemented");
        
        $this->Logger->log(/* parameters */);
    }

    /**
     * Tests Logger::getConfig()
     */
    public function testGetConfig()
    {
        // TODO Auto-generated LoggerTest::testGetConfig()
        $this->markTestIncomplete("getConfig test not implemented");
        
        Logger::getConfig(/* parameters */);
    }
}

