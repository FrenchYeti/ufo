<?php
require_once 'tests/Error/StandardException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * StandardException test case.
 */
class StandardExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var StandardException
     */
    private $StandardException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated StandardExceptionTest::setUp()
        
        $this->StandardException = new StandardException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated StandardExceptionTest::tearDown()
        $this->StandardException = null;
        
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
     * Tests StandardException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated StandardExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->StandardException->__construct(/* parameters */);
    }

    /**
     * Tests StandardException->__toString()
     */
    public function test__toString()
    {
        // TODO Auto-generated StandardExceptionTest->test__toString()
        $this->markTestIncomplete("__toString test not implemented");
        
        $this->StandardException->__toString(/* parameters */);
    }
}

