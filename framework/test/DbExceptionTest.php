<?php
require_once 'UFO/Error/DbException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * DbException test case.
 */
class DbExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var DbException
     */
    private $DbException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated DbExceptionTest::setUp()
        
        $this->DbException = new DbException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated DbExceptionTest::tearDown()
        $this->DbException = null;
        
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
     * Tests DbException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated DbExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->DbException->__construct(/* parameters */);
    }

    /**
     * Tests DbException->__toString()
     */
    public function test__toString()
    {
        // TODO Auto-generated DbExceptionTest->test__toString()
        $this->markTestIncomplete("__toString test not implemented");
        
        $this->DbException->__toString(/* parameters */);
    }
}

