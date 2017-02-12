<?php
require_once 'tests/Security/AdvancedPasswordManagement.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * AdvancedPasswordManagement test case.
 */
class AdvancedPasswordManagementTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var AdvancedPasswordManagement
     */
    private $AdvancedPasswordManagement;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated AdvancedPasswordManagementTest::setUp()
        
        $this->AdvancedPasswordManagement = new AdvancedPasswordManagement(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AdvancedPasswordManagementTest::tearDown()
        $this->AdvancedPasswordManagement = null;
        
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
     * Tests AdvancedPasswordManagement->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated AdvancedPasswordManagementTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->AdvancedPasswordManagement->__construct(/* parameters */);
    }

    /**
     * Tests AdvancedPasswordManagement::checkIfTempPassExpired()
     */
    public function testCheckIfTempPassExpired()
    {
        // TODO Auto-generated AdvancedPasswordManagementTest::testCheckIfTempPassExpired()
        $this->markTestIncomplete("checkIfTempPassExpired test not implemented");
        
        AdvancedPasswordManagement::checkIfTempPassExpired(/* parameters */);
    }

    /**
     * Tests AdvancedPasswordManagement::tempPassword()
     */
    public function testTempPassword()
    {
        // TODO Auto-generated AdvancedPasswordManagementTest::testTempPassword()
        $this->markTestIncomplete("tempPassword test not implemented");
        
        AdvancedPasswordManagement::tempPassword(/* parameters */);
    }
}

