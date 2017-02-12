<?php
require_once 'UFO/Directory/DirectoryGroup.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * DirectoryGroup test case.
 */
class DirectoryGroupTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var DirectoryGroup
     */
    private $DirectoryGroup;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated DirectoryGroupTest::setUp()
        
        $this->DirectoryGroup = new DirectoryGroup(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated DirectoryGroupTest::tearDown()
        $this->DirectoryGroup = null;
        
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
     * Tests DirectoryGroup->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated DirectoryGroupTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->DirectoryGroup->__construct(/* parameters */);
    }

    /**
     * Tests DirectoryGroup->getRoles()
     */
    public function testGetRoles()
    {
        // TODO Auto-generated DirectoryGroupTest->testGetRoles()
        $this->markTestIncomplete("getRoles test not implemented");
        
        $this->DirectoryGroup->getRoles(/* parameters */);
    }
}

