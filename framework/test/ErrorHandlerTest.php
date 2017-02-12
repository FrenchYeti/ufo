<?php
require_once 'UFO/Error/ErrorHandler.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * ErrorHandler test case.
 */
class ErrorHandlerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ErrorHandler
     */
    private $ErrorHandler;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated ErrorHandlerTest::setUp()
        
        $this->ErrorHandler = new ErrorHandler(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ErrorHandlerTest::tearDown()
        $this->ErrorHandler = null;
        
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
     * Tests ErrorHandler::enable()
     */
    public function testEnable()
    {
        // TODO Auto-generated ErrorHandlerTest::testEnable()
        $this->markTestIncomplete("enable test not implemented");
        
        ErrorHandler::enable(/* parameters */);
    }

    /**
     * Tests ErrorHandler::disable()
     */
    public function testDisable()
    {
        // TODO Auto-generated ErrorHandlerTest::testDisable()
        $this->markTestIncomplete("disable test not implemented");
        
        ErrorHandler::disable(/* parameters */);
    }

    /**
     * Tests ErrorHandler::isActive()
     */
    public function testIsActive()
    {
        // TODO Auto-generated ErrorHandlerTest::testIsActive()
        $this->markTestIncomplete("isActive test not implemented");
        
        ErrorHandler::isActive(/* parameters */);
    }

    /**
     * Tests ErrorHandler::_shutdown()
     */
    public function test_shutdown()
    {
        // TODO Auto-generated ErrorHandlerTest::test_shutdown()
        $this->markTestIncomplete("_shutdown test not implemented");
        
        ErrorHandler::_shutdown(/* parameters */);
    }

    /**
     * Tests ErrorHandler::_errorToException()
     */
    public function test_errorToException()
    {
        // TODO Auto-generated ErrorHandlerTest::test_errorToException()
        $this->markTestIncomplete("_errorToException test not implemented");
        
        ErrorHandler::_errorToException(/* parameters */);
    }

    /**
     * Tests ErrorHandler::dump()
     */
    public function testDump()
    {
        // TODO Auto-generated ErrorHandlerTest::testDump()
        $this->markTestIncomplete("dump test not implemented");
        
        ErrorHandler::dump(/* parameters */);
    }

    /**
     * Tests ErrorHandler::devel()
     */
    public function testDevel()
    {
        // TODO Auto-generated ErrorHandlerTest::testDevel()
        $this->markTestIncomplete("devel test not implemented");
        
        ErrorHandler::devel(/* parameters */);
    }

    /**
     * Tests ErrorHandler::prod()
     */
    public function testProd()
    {
        // TODO Auto-generated ErrorHandlerTest::testProd()
        $this->markTestIncomplete("prod test not implemented");
        
        ErrorHandler::prod(/* parameters */);
    }
}

