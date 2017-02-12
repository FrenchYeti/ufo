<?php
require_once 'UFO/Db/Profile.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Profile test case.
 */
class ProfileTest extends PHPUnit_Framework_TestCase
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
        
        // TODO Auto-generated ProfileTest::setUp()
        
        $this->Profile = new Profile(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ProfileTest::tearDown()
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
        // TODO Auto-generated ProfileTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->Profile->__construct(/* parameters */);
    }

    /**
     * Tests Profile->isLoaded()
     */
    public function testIsLoaded()
    {
        // TODO Auto-generated ProfileTest->testIsLoaded()
        $this->markTestIncomplete("isLoaded test not implemented");
        
        $this->Profile->isLoaded(/* parameters */);
    }

    /**
     * Tests Profile->getProfilName()
     */
    public function testGetProfilName()
    {
        // TODO Auto-generated ProfileTest->testGetProfilName()
        $this->markTestIncomplete("getProfilName test not implemented");
        
        $this->Profile->getProfilName(/* parameters */);
    }

    /**
     * Tests Profile->getDBMS()
     */
    public function testGetDBMS()
    {
        // TODO Auto-generated ProfileTest->testGetDBMS()
        $this->markTestIncomplete("getDBMS test not implemented");
        
        $this->Profile->getDBMS(/* parameters */);
    }

    /**
     * Tests Profile->getNAME()
     */
    public function testGetNAME()
    {
        // TODO Auto-generated ProfileTest->testGetNAME()
        $this->markTestIncomplete("getNAME test not implemented");
        
        $this->Profile->getNAME(/* parameters */);
    }

    /**
     * Tests Profile->getSERVER()
     */
    public function testGetSERVER()
    {
        // TODO Auto-generated ProfileTest->testGetSERVER()
        $this->markTestIncomplete("getSERVER test not implemented");
        
        $this->Profile->getSERVER(/* parameters */);
    }

    /**
     * Tests Profile->getSERVER_PORT()
     */
    public function testGetSERVER_PORT()
    {
        // TODO Auto-generated ProfileTest->testGetSERVER_PORT()
        $this->markTestIncomplete("getSERVER_PORT test not implemented");
        
        $this->Profile->getSERVER_PORT(/* parameters */);
    }

    /**
     * Tests Profile->getUSER()
     */
    public function testGetUSER()
    {
        // TODO Auto-generated ProfileTest->testGetUSER()
        $this->markTestIncomplete("getUSER test not implemented");
        
        $this->Profile->getUSER(/* parameters */);
    }

    /**
     * Tests Profile->getPASS()
     */
    public function testGetPASS()
    {
        // TODO Auto-generated ProfileTest->testGetPASS()
        $this->markTestIncomplete("getPASS test not implemented");
        
        $this->Profile->getPASS(/* parameters */);
    }

    /**
     * Tests Profile->getCASE()
     */
    public function testGetCASE()
    {
        // TODO Auto-generated ProfileTest->testGetCASE()
        $this->markTestIncomplete("getCASE test not implemented");
        
        $this->Profile->getCASE(/* parameters */);
    }

    /**
     * Tests Profile->canREAD()
     */
    public function testCanREAD()
    {
        // TODO Auto-generated ProfileTest->testCanREAD()
        $this->markTestIncomplete("canREAD test not implemented");
        
        $this->Profile->canREAD(/* parameters */);
    }

    /**
     * Tests Profile->canCREATE()
     */
    public function testCanCREATE()
    {
        // TODO Auto-generated ProfileTest->testCanCREATE()
        $this->markTestIncomplete("canCREATE test not implemented");
        
        $this->Profile->canCREATE(/* parameters */);
    }

    /**
     * Tests Profile->canUPDATE()
     */
    public function testCanUPDATE()
    {
        // TODO Auto-generated ProfileTest->testCanUPDATE()
        $this->markTestIncomplete("canUPDATE test not implemented");
        
        $this->Profile->canUPDATE(/* parameters */);
    }

    /**
     * Tests Profile->canDELETE()
     */
    public function testCanDELETE()
    {
        // TODO Auto-generated ProfileTest->testCanDELETE()
        $this->markTestIncomplete("canDELETE test not implemented");
        
        $this->Profile->canDELETE(/* parameters */);
    }
}

