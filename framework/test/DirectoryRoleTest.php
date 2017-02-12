<?php
require_once 'UFO/Directory/DirectoryRole.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * DirectoryRole test case.
 */
class DirectoryRoleTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var DirectoryRole
     */
    private $DirectoryRole;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated DirectoryRoleTest::setUp()
        
        $this->DirectoryRole = new DirectoryRole(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated DirectoryRoleTest::tearDown()
        $this->DirectoryRole = null;
        
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
     * Tests DirectoryRole->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated DirectoryRoleTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->DirectoryRole->__construct(/* parameters */);
    }

    /**
     * Tests DirectoryRole->importRoleProfile()
     */
    public function testImportRoleProfile()
    {
        // TODO Auto-generated DirectoryRoleTest->testImportRoleProfile()
        $this->markTestIncomplete("importRoleProfile test not implemented");
        
        $this->DirectoryRole->importRoleProfile(/* parameters */);
    }

    /**
     * Tests DirectoryRole->importProfileFromFile()
     */
    public function testImportProfileFromFile()
    {
        // TODO Auto-generated DirectoryRoleTest->testImportProfileFromFile()
        $this->markTestIncomplete("importProfileFromFile test not implemented");
        
        $this->DirectoryRole->importProfileFromFile(/* parameters */);
    }

    /**
     * Tests DirectoryRole->importProfileFromDB()
     */
    public function testImportProfileFromDB()
    {
        // TODO Auto-generated DirectoryRoleTest->testImportProfileFromDB()
        $this->markTestIncomplete("importProfileFromDB test not implemented");
        
        $this->DirectoryRole->importProfileFromDB(/* parameters */);
    }

    /**
     * Tests DirectoryRole->getUserClass()
     */
    public function testGetUserClass()
    {
        // TODO Auto-generated DirectoryRoleTest->testGetUserClass()
        $this->markTestIncomplete("getUserClass test not implemented");
        
        $this->DirectoryRole->getUserClass(/* parameters */);
    }

    /**
     * Tests DirectoryRole->newUserClass()
     */
    public function testNewUserClass()
    {
        // TODO Auto-generated DirectoryRoleTest->testNewUserClass()
        $this->markTestIncomplete("newUserClass test not implemented");
        
        $this->DirectoryRole->newUserClass(/* parameters */);
    }

    /**
     * Tests DirectoryRole::getRoleByName()
     */
    public function testGetRoleByName()
    {
        // TODO Auto-generated DirectoryRoleTest::testGetRoleByName()
        $this->markTestIncomplete("getRoleByName test not implemented");
        
        DirectoryRole::getRoleByName(/* parameters */);
    }
}

