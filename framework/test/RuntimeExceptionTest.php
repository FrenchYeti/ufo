<?php
require_once 'UFO/Captcha/Exception/RuntimeException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * RuntimeException test case.
 */
class RuntimeExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var RuntimeException
     */
    private $RuntimeException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated RuntimeExceptionTest::setUp()
        
        $this->RuntimeException = new RuntimeException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated RuntimeExceptionTest::tearDown()
        $this->RuntimeException = null;
        
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
     * Tests RuntimeException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated RuntimeExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->RuntimeException->__construct(/* parameters */);
    }

    /**
     * Tests RuntimeException->__toString()
     */
    public function test__toString()
    {
        // TODO Auto-generated RuntimeExceptionTest->test__toString()
        $this->markTestIncomplete("__toString test not implemented");
        
        $this->RuntimeException->__toString(/* parameters */);
    }
}

