<?php
require_once 'UFO/Error/MutatorException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * MutatorException test case.
 */
class MutatorExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var MutatorException
     */
    private $MutatorException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated MutatorExceptionTest::setUp()
        
        $this->MutatorException = new MutatorException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated MutatorExceptionTest::tearDown()
        $this->MutatorException = null;
        
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
     * Tests MutatorException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated MutatorExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->MutatorException->__construct(/* parameters */);
    }
}

