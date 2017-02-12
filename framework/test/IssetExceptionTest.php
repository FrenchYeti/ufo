<?php
require_once 'UFO/Error/IssetException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * IssetException test case.
 */
class IssetExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var IssetException
     */
    private $IssetException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated IssetExceptionTest::setUp()
        
        $this->IssetException = new IssetException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated IssetExceptionTest::tearDown()
        $this->IssetException = null;
        
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
     * Tests IssetException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated IssetExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->IssetException->__construct(/* parameters */);
    }
}

