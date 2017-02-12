<?php
require_once 'tests/RBAC/Authorization.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Authorization test case.
 */
class AuthorizationTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Authorization
     */
    private $Authorization;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated AuthorizationTest::setUp()
        
        $this->Authorization = new Authorization(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AuthorizationTest::tearDown()
        $this->Authorization = null;
        
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
     * Tests Authorization::deleteByRole()
     */
    public function testDeleteByRole()
    {
        // TODO Auto-generated AuthorizationTest::testDeleteByRole()
        $this->markTestIncomplete("deleteByRole test not implemented");
        
        Authorization::deleteByRole(/* parameters */);
    }

    /**
     * Tests Authorization::getFromRole()
     */
    public function testGetFromRole()
    {
        // TODO Auto-generated AuthorizationTest::testGetFromRole()
        $this->markTestIncomplete("getFromRole test not implemented");
        
        Authorization::getFromRole(/* parameters */);
    }

    /**
     * Tests Authorization::deleteFromOperation()
     */
    public function testDeleteFromOperation()
    {
        // TODO Auto-generated AuthorizationTest::testDeleteFromOperation()
        $this->markTestIncomplete("deleteFromOperation test not implemented");
        
        Authorization::deleteFromOperation(/* parameters */);
    }

    /**
     * Tests Authorization::getFromOperation()
     */
    public function testGetFromOperation()
    {
        // TODO Auto-generated AuthorizationTest::testGetFromOperation()
        $this->markTestIncomplete("getFromOperation test not implemented");
        
        Authorization::getFromOperation(/* parameters */);
    }

    /**
     * Tests Authorization::newAuthorization()
     */
    public function testNewAuthorization()
    {
        // TODO Auto-generated AuthorizationTest::testNewAuthorization()
        $this->markTestIncomplete("newAuthorization test not implemented");
        
        Authorization::newAuthorization(/* parameters */);
    }

    /**
     * Tests Authorization::removeAuthorization()
     */
    public function testRemoveAuthorization()
    {
        // TODO Auto-generated AuthorizationTest::testRemoveAuthorization()
        $this->markTestIncomplete("removeAuthorization test not implemented");
        
        Authorization::removeAuthorization(/* parameters */);
    }

    /**
     * Tests Authorization->getOperation()
     */
    public function testGetOperation()
    {
        // TODO Auto-generated AuthorizationTest->testGetOperation()
        $this->markTestIncomplete("getOperation test not implemented");
        
        $this->Authorization->getOperation(/* parameters */);
    }

    /**
     * Tests Authorization->getRole()
     */
    public function testGetRole()
    {
        // TODO Auto-generated AuthorizationTest->testGetRole()
        $this->markTestIncomplete("getRole test not implemented");
        
        $this->Authorization->getRole(/* parameters */);
    }
}

