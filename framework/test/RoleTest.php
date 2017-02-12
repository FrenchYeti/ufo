<?php
require_once 'tests/RBAC/Role.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Role test case.
 */
class RoleTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Role
     */
    private $Role;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated RoleTest::setUp()
        
        $this->Role = new Role(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated RoleTest::tearDown()
        $this->Role = null;
        
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
     * Tests Role::checkID()
     */
    public function testCheckID()
    {
        // TODO Auto-generated RoleTest::testCheckID()
        $this->markTestIncomplete("checkID test not implemented");
        
        Role::checkID(/* parameters */);
    }

    /**
     * Tests Role::instanciate()
     */
    public function testInstanciate()
    {
        // TODO Auto-generated RoleTest::testInstanciate()
        $this->markTestIncomplete("instanciate test not implemented");
        
        Role::instanciate(/* parameters */);
    }

    /**
     * Tests Role::checkName()
     */
    public function testCheckName()
    {
        // TODO Auto-generated RoleTest::testCheckName()
        $this->markTestIncomplete("checkName test not implemented");
        
        Role::checkName(/* parameters */);
    }

    /**
     * Tests Role::checkDescription()
     */
    public function testCheckDescription()
    {
        // TODO Auto-generated RoleTest::testCheckDescription()
        $this->markTestIncomplete("checkDescription test not implemented");
        
        Role::checkDescription(/* parameters */);
    }

    /**
     * Tests Role::IDexists()
     */
    public function testIDexists()
    {
        // TODO Auto-generated RoleTest::testIDexists()
        $this->markTestIncomplete("IDexists test not implemented");
        
        Role::IDexists(/* parameters */);
    }

    /**
     * Tests Role::getByID()
     */
    public function testGetByID()
    {
        // TODO Auto-generated RoleTest::testGetByID()
        $this->markTestIncomplete("getByID test not implemented");
        
        Role::getByID(/* parameters */);
    }

    /**
     * Tests Role::getByName()
     */
    public function testGetByName()
    {
        // TODO Auto-generated RoleTest::testGetByName()
        $this->markTestIncomplete("getByName test not implemented");
        
        Role::getByName(/* parameters */);
    }

    /**
     * Tests Role::getAll()
     */
    public function testGetAll()
    {
        // TODO Auto-generated RoleTest::testGetAll()
        $this->markTestIncomplete("getAll test not implemented");
        
        Role::getAll(/* parameters */);
    }

    /**
     * Tests Role->newRole()
     */
    public function testNewRole()
    {
        // TODO Auto-generated RoleTest->testNewRole()
        $this->markTestIncomplete("newRole test not implemented");
        
        $this->Role->newRole(/* parameters */);
    }

    /**
     * Tests Role->update()
     */
    public function testUpdate()
    {
        // TODO Auto-generated RoleTest->testUpdate()
        $this->markTestIncomplete("update test not implemented");
        
        $this->Role->update(/* parameters */);
    }

    /**
     * Tests Role->changeName()
     */
    public function testChangeName()
    {
        // TODO Auto-generated RoleTest->testChangeName()
        $this->markTestIncomplete("changeName test not implemented");
        
        $this->Role->changeName(/* parameters */);
    }

    /**
     * Tests Role->changeDbProfileName()
     */
    public function testChangeDbProfileName()
    {
        // TODO Auto-generated RoleTest->testChangeDbProfileName()
        $this->markTestIncomplete("changeDbProfileName test not implemented");
        
        $this->Role->changeDbProfileName(/* parameters */);
    }

    /**
     * Tests Role->deleteRole()
     */
    public function testDeleteRole()
    {
        // TODO Auto-generated RoleTest->testDeleteRole()
        $this->markTestIncomplete("deleteRole test not implemented");
        
        $this->Role->deleteRole(/* parameters */);
    }

    /**
     * Tests Role->countUserDepends()
     */
    public function testCountUserDepends()
    {
        // TODO Auto-generated RoleTest->testCountUserDepends()
        $this->markTestIncomplete("countUserDepends test not implemented");
        
        $this->Role->countUserDepends(/* parameters */);
    }

    /**
     * Tests Role->getID()
     */
    public function testGetID()
    {
        // TODO Auto-generated RoleTest->testGetID()
        $this->markTestIncomplete("getID test not implemented");
        
        $this->Role->getID(/* parameters */);
    }

    /**
     * Tests Role->getAuthorizations()
     */
    public function testGetAuthorizations()
    {
        // TODO Auto-generated RoleTest->testGetAuthorizations()
        $this->markTestIncomplete("getAuthorizations test not implemented");
        
        $this->Role->getAuthorizations(/* parameters */);
    }

    /**
     * Tests Role->addAuthorization()
     */
    public function testAddAuthorization()
    {
        // TODO Auto-generated RoleTest->testAddAuthorization()
        $this->markTestIncomplete("addAuthorization test not implemented");
        
        $this->Role->addAuthorization(/* parameters */);
    }

    /**
     * Tests Role->removeAuthorization()
     */
    public function testRemoveAuthorization()
    {
        // TODO Auto-generated RoleTest->testRemoveAuthorization()
        $this->markTestIncomplete("removeAuthorization test not implemented");
        
        $this->Role->removeAuthorization(/* parameters */);
    }

    /**
     * Tests Role->getName()
     */
    public function testGetName()
    {
        // TODO Auto-generated RoleTest->testGetName()
        $this->markTestIncomplete("getName test not implemented");
        
        $this->Role->getName(/* parameters */);
    }

    /**
     * Tests Role->getDbProfileName()
     */
    public function testGetDbProfileName()
    {
        // TODO Auto-generated RoleTest->testGetDbProfileName()
        $this->markTestIncomplete("getDbProfileName test not implemented");
        
        $this->Role->getDbProfileName(/* parameters */);
    }

    /**
     * Tests Role->isAuthorized()
     */
    public function testIsAuthorized()
    {
        // TODO Auto-generated RoleTest->testIsAuthorized()
        $this->markTestIncomplete("isAuthorized test not implemented");
        
        $this->Role->isAuthorized(/* parameters */);
    }

    /**
     * Tests Role->toArray()
     */
    public function testToArray()
    {
        // TODO Auto-generated RoleTest->testToArray()
        $this->markTestIncomplete("toArray test not implemented");
        
        $this->Role->toArray(/* parameters */);
    }
}

