<?php
require_once 'tests/User/XUser.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * XUser test case.
 */
class XUserTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var XUser
     */
    private $XUser;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated XUserTest::setUp()
        
        $this->XUser = new XUser(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated XUserTest::tearDown()
        $this->XUser = null;
        
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
     * Tests XUser->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated XUserTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->XUser->__construct(/* parameters */);
    }

    /**
     * Tests XUser->setName()
     */
    public function testSetName()
    {
        // TODO Auto-generated XUserTest->testSetName()
        $this->markTestIncomplete("setName test not implemented");
        
        $this->XUser->setName(/* parameters */);
    }

    /**
     * Tests XUser->setSecondaryEmail()
     */
    public function testSetSecondaryEmail()
    {
        // TODO Auto-generated XUserTest->testSetSecondaryEmail()
        $this->markTestIncomplete("setSecondaryEmail test not implemented");
        
        $this->XUser->setSecondaryEmail(/* parameters */);
    }

    /**
     * Tests XUser->setDOB()
     */
    public function testSetDOB()
    {
        // TODO Auto-generated XUserTest->testSetDOB()
        $this->markTestIncomplete("setDOB test not implemented");
        
        $this->XUser->setDOB(/* parameters */);
    }

    /**
     * Tests XUser->ageCheck()
     */
    public function testAgeCheck()
    {
        // TODO Auto-generated XUserTest->testAgeCheck()
        $this->markTestIncomplete("ageCheck test not implemented");
        
        $this->XUser->ageCheck(/* parameters */);
    }

    /**
     * Tests XUser->deleteXUser()
     */
    public function testDeleteXUser()
    {
        // TODO Auto-generated XUserTest->testDeleteXUser()
        $this->markTestIncomplete("deleteXUser test not implemented");
        
        $this->XUser->deleteXUser(/* parameters */);
    }
}

