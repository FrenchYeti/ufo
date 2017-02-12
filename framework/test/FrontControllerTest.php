<?php
require_once 'tests/Controller/FrontController.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * FrontController test case.
 */
class FrontControllerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var FrontController
     */
    private $FrontController;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated FrontControllerTest::setUp()
        
        $this->FrontController = new FrontController(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated FrontControllerTest::tearDown()
        $this->FrontController = null;
        
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
     * Tests FrontController->Start()
     */
    public function testStart()
    {
        // TODO Auto-generated FrontControllerTest->testStart()
        $this->markTestIncomplete("Start test not implemented");
        
        $this->FrontController->Start(/* parameters */);
    }

    /**
     * Tests FrontController->NotFound()
     */
    public function testNotFound()
    {
        // TODO Auto-generated FrontControllerTest->testNotFound()
        $this->markTestIncomplete("NotFound test not implemented");
        
        $this->FrontController->NotFound(/* parameters */);
    }
}

