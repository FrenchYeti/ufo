<?php
require_once 'UFO/Entity/Db/Check/TemplateCommand.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * TemplateCommand test case.
 */
class TemplateCommandTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var TemplateCommand
     */
    private $TemplateCommand;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated TemplateCommandTest::setUp()
        
        $this->TemplateCommand = new TemplateCommand(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated TemplateCommandTest::tearDown()
        $this->TemplateCommand = null;
        
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
     * Tests TemplateCommand->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated TemplateCommandTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->TemplateCommand->__construct(/* parameters */);
    }

    /**
     * Tests TemplateCommand->check()
     */
    public function testCheck()
    {
        // TODO Auto-generated TemplateCommandTest->testCheck()
        $this->markTestIncomplete("check test not implemented");
        
        $this->TemplateCommand->check(/* parameters */);
    }
}

