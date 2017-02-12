<?php
require_once 'UFO/Error/CallException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * CallException test case.
 */
class CallExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var CallException
     */
    private $CallException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated CallExceptionTest::setUp()
        
        $this->CallException = new CallException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated CallExceptionTest::tearDown()
        $this->CallException = null;
        
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
     * Tests CallException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated CallExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->CallException->__construct(/* parameters */);
    }
}

