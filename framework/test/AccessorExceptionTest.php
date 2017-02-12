<?php
require_once 'UFO/Error/AccessorException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * AccessorException test case.
 */
class AccessorExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var AccessorException
     */
    private $AccessorException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated AccessorExceptionTest::setUp()
        
        $this->AccessorException = new AccessorException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AccessorExceptionTest::tearDown()
        $this->AccessorException = null;
        
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
     * Tests AccessorException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated AccessorExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->AccessorException->__construct(/* parameters */);
    }
}

