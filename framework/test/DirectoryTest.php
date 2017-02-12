<?php
require_once 'UFO/Directory/Directory.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Directory test case.
 */
class DirectoryTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Directory
     */
    private $Directory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated DirectoryTest::setUp()
        
        $this->Directory = new Directory(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated DirectoryTest::tearDown()
        $this->Directory = null;
        
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
     * Tests Directory::getInstance()
     */
    public function testGetInstance()
    {
        // TODO Auto-generated DirectoryTest::testGetInstance()
        $this->markTestIncomplete("getInstance test not implemented");
        
        Directory::getInstance(/* parameters */);
    }

    /**
     * Tests Directory::getGroup()
     */
    public function testGetGroup()
    {
        // TODO Auto-generated DirectoryTest::testGetGroup()
        $this->markTestIncomplete("getGroup test not implemented");
        
        Directory::getGroup(/* parameters */);
    }

    /**
     * Tests Directory->linkGroup()
     */
    public function testLinkGroup()
    {
        // TODO Auto-generated DirectoryTest->testLinkGroup()
        $this->markTestIncomplete("linkGroup test not implemented");
        
        $this->Directory->linkGroup(/* parameters */);
    }
}

