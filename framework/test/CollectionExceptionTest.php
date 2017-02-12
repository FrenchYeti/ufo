<?php
require_once 'UFO/Error/CollectionException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * CollectionException test case.
 */
class CollectionExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var CollectionException
     */
    private $CollectionException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated CollectionExceptionTest::setUp()
        
        $this->CollectionException = new CollectionException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated CollectionExceptionTest::tearDown()
        $this->CollectionException = null;
        
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
     * Tests CollectionException->getCustomMessage()
     */
    public function testGetCustomMessage()
    {
        // TODO Auto-generated CollectionExceptionTest->testGetCustomMessage()
        $this->markTestIncomplete("getCustomMessage test not implemented");
        
        $this->CollectionException->getCustomMessage(/* parameters */);
    }

    /**
     * Tests CollectionException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated CollectionExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->CollectionException->__construct(/* parameters */);
    }
}

