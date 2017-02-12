<?php
require_once 'tests/Error/UnsetException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * UnsetException test case.
 */
class UnsetExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var UnsetException
     */
    private $UnsetException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated UnsetExceptionTest::setUp()
        
        $this->UnsetException = new UnsetException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UnsetExceptionTest::tearDown()
        $this->UnsetException = null;
        
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
     * Tests UnsetException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated UnsetExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->UnsetException->__construct(/* parameters */);
    }
}

