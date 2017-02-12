<?php
require_once 'tests/Error/Stack.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Stack test case.
 */
class StackTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Stack
     */
    private $Stack;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated StackTest::setUp()
        
        $this->Stack = new Stack(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated StackTest::tearDown()
        $this->Stack = null;
        
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
     * Tests Stack::getInstance()
     */
    public function testGetInstance()
    {
        // TODO Auto-generated StackTest::testGetInstance()
        $this->markTestIncomplete("getInstance test not implemented");
        
        Stack::getInstance(/* parameters */);
    }

    /**
     * Tests Stack->addError()
     */
    public function testAddError()
    {
        // TODO Auto-generated StackTest->testAddError()
        $this->markTestIncomplete("addError test not implemented");
        
        $this->Stack->addError(/* parameters */);
    }

    /**
     * Tests Stack->dumpStack()
     */
    public function testDumpStack()
    {
        // TODO Auto-generated StackTest->testDumpStack()
        $this->markTestIncomplete("dumpStack test not implemented");
        
        $this->Stack->dumpStack(/* parameters */);
    }

    /**
     * Tests Stack->getLevelMax()
     */
    public function testGetLevelMax()
    {
        // TODO Auto-generated StackTest->testGetLevelMax()
        $this->markTestIncomplete("getLevelMax test not implemented");
        
        $this->Stack->getLevelMax(/* parameters */);
    }

    /**
     * Tests Stack->manageError()
     */
    public function testManageError()
    {
        // TODO Auto-generated StackTest->testManageError()
        $this->markTestIncomplete("manageError test not implemented");
        
        $this->Stack->manageError(/* parameters */);
    }
}

