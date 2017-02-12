<?php
require_once 'UFO/Entity/Db/Link/ColumnLink.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * ColumnLink test case.
 */
class ColumnLinkTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ColumnLink
     */
    private $ColumnLink;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated ColumnLinkTest::setUp()
        
        $this->ColumnLink = new ColumnLink(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ColumnLinkTest::tearDown()
        $this->ColumnLink = null;
        
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
     * Tests ColumnLink::checkName()
     */
    public function testCheckName()
    {
        // TODO Auto-generated ColumnLinkTest::testCheckName()
        $this->markTestIncomplete("checkName test not implemented");
        
        ColumnLink::checkName(/* parameters */);
    }

    /**
     * Tests ColumnLink->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated ColumnLinkTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->ColumnLink->__construct(/* parameters */);
    }

    /**
     * Tests ColumnLink->getName()
     */
    public function testGetName()
    {
        // TODO Auto-generated ColumnLinkTest->testGetName()
        $this->markTestIncomplete("getName test not implemented");
        
        $this->ColumnLink->getName(/* parameters */);
    }

    /**
     * Tests ColumnLink->getMaxLength()
     */
    public function testGetMaxLength()
    {
        // TODO Auto-generated ColumnLinkTest->testGetMaxLength()
        $this->markTestIncomplete("getMaxLength test not implemented");
        
        $this->ColumnLink->getMaxLength(/* parameters */);
    }

    /**
     * Tests ColumnLink->getType()
     */
    public function testGetType()
    {
        // TODO Auto-generated ColumnLinkTest->testGetType()
        $this->markTestIncomplete("getType test not implemented");
        
        $this->ColumnLink->getType(/* parameters */);
    }

    /**
     * Tests ColumnLink->check()
     */
    public function testCheck()
    {
        // TODO Auto-generated ColumnLinkTest->testCheck()
        $this->markTestIncomplete("check test not implemented");
        
        $this->ColumnLink->check(/* parameters */);
    }

    /**
     * Tests ColumnLink->isFacultative()
     */
    public function testIsFacultative()
    {
        // TODO Auto-generated ColumnLinkTest->testIsFacultative()
        $this->markTestIncomplete("isFacultative test not implemented");
        
        $this->ColumnLink->isFacultative(/* parameters */);
    }
}

