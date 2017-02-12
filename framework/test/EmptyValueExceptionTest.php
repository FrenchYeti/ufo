<?php
require_once 'UFO/Entity/Db/Exception/EmptyValueException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * EmptyValueException test case.
 */
class EmptyValueExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var EmptyValueException
     */
    private $EmptyValueException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated EmptyValueExceptionTest::setUp()
        
        $this->EmptyValueException = new EmptyValueException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated EmptyValueExceptionTest::tearDown()
        $this->EmptyValueException = null;
        
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
     * Tests EmptyValueException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated EmptyValueExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->EmptyValueException->__construct(/* parameters */);
    }
}

