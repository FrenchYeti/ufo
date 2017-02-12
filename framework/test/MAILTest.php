<?php
require_once 'tests/Log/Workers/MAIL.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * MAIL test case.
 */
class MAILTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var MAIL
     */
    private $MAIL;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated MAILTest::setUp()
        
        $this->MAIL = new MAIL(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated MAILTest::tearDown()
        $this->MAIL = null;
        
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
     * Tests MAIL->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated MAILTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->MAIL->__construct(/* parameters */);
    }

    /**
     * Tests MAIL->log()
     */
    public function testLog()
    {
        // TODO Auto-generated MAILTest->testLog()
        $this->markTestIncomplete("log test not implemented");
        
        $this->MAIL->log(/* parameters */);
    }
}

