<?php
require_once 'UFO/Entity/Db/Link/TableLink.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * TableLink test case.
 */
class TableLinkTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var TableLink
     */
    private $TableLink;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated TableLinkTest::setUp()
        
        $this->TableLink = new TableLink(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated TableLinkTest::tearDown()
        $this->TableLink = null;
        
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
     * Tests TableLink::checkName()
     */
    public function testCheckName()
    {
        // TODO Auto-generated TableLinkTest::testCheckName()
        $this->markTestIncomplete("checkName test not implemented");
        
        TableLink::checkName(/* parameters */);
    }

    /**
     * Tests TableLink::checkPrefix()
     */
    public function testCheckPrefix()
    {
        // TODO Auto-generated TableLinkTest::testCheckPrefix()
        $this->markTestIncomplete("checkPrefix test not implemented");
        
        TableLink::checkPrefix(/* parameters */);
    }

    /**
     * Tests TableLink->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated TableLinkTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->TableLink->__construct(/* parameters */);
    }

    /**
     * Tests TableLink->getName()
     */
    public function testGetName()
    {
        // TODO Auto-generated TableLinkTest->testGetName()
        $this->markTestIncomplete("getName test not implemented");
        
        $this->TableLink->getName(/* parameters */);
    }

    /**
     * Tests TableLink->getPrefix()
     */
    public function testGetPrefix()
    {
        // TODO Auto-generated TableLinkTest->testGetPrefix()
        $this->markTestIncomplete("getPrefix test not implemented");
        
        $this->TableLink->getPrefix(/* parameters */);
    }
}

