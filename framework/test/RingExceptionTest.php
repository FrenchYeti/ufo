<?php
require_once 'tests/Security/Exception/RingException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * RingException test case.
 */
class RingExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var RingException
     */
    private $RingException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated RingExceptionTest::setUp()
        
        $this->RingException = new RingException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated RingExceptionTest::tearDown()
        $this->RingException = null;
        
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
     * Tests RingException->runCode()
     */
    public function testRunCode()
    {
        // TODO Auto-generated RingExceptionTest->testRunCode()
        $this->markTestIncomplete("runCode test not implemented");
        
        $this->RingException->runCode(/* parameters */);
    }

    /**
     * Tests RingException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated RingExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->RingException->__construct(/* parameters */);
    }
}

