<?php
require_once 'UFO/Entity/Db/Exception/EntityException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * EntityException test case.
 */
class EntityExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var EntityException
     */
    private $EntityException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated EntityExceptionTest::setUp()
        
        $this->EntityException = new EntityException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated EntityExceptionTest::tearDown()
        $this->EntityException = null;
        
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
     * Tests EntityException->runCode()
     */
    public function testRunCode()
    {
        // TODO Auto-generated EntityExceptionTest->testRunCode()
        $this->markTestIncomplete("runCode test not implemented");
        
        $this->EntityException->runCode(/* parameters */);
    }

    /**
     * Tests EntityException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated EntityExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->EntityException->__construct(/* parameters */);
    }
}

