<?php
require_once 'tests/Session/Profile.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Profile test case.
 */
class ProfileSessionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Profile
     */
    private $Profile;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated ProfileSessionTest::setUp()
        
        $this->Profile = new Profile(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ProfileSessionTest::tearDown()
        $this->Profile = null;
        
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
     * Tests Profile->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated ProfileSessionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->Profile->__construct(/* parameters */);
    }

    /**
     * Tests Profile->isLoaded()
     */
    public function testIsLoaded()
    {
        // TODO Auto-generated ProfileSessionTest->testIsLoaded()
        $this->markTestIncomplete("isLoaded test not implemented");
        
        $this->Profile->isLoaded(/* parameters */);
    }

    /**
     * Tests Profile->getProfilName()
     */
    public function testGetProfilName()
    {
        // TODO Auto-generated ProfileSessionTest->testGetProfilName()
        $this->markTestIncomplete("getProfilName test not implemented");
        
        $this->Profile->getProfilName(/* parameters */);
    }

    /**
     * Tests Profile->get()
     */
    public function testGet()
    {
        // TODO Auto-generated ProfileSessionTest->testGet()
        $this->markTestIncomplete("get test not implemented");
        
        $this->Profile->get(/* parameters */);
    }
}

