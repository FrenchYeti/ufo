<?php
require_once 'tests/RBAC/OperationCategorie.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * OperationCategorie test case.
 */
class OperationCategorieTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var OperationCategorie
     */
    private $OperationCategorie;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated OperationCategorieTest::setUp()
        
        $this->OperationCategorie = new OperationCategorie(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated OperationCategorieTest::tearDown()
        $this->OperationCategorie = null;
        
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
     * Tests OperationCategorie::checkID()
     */
    public function testCheckID()
    {
        // TODO Auto-generated OperationCategorieTest::testCheckID()
        $this->markTestIncomplete("checkID test not implemented");
        
        OperationCategorie::checkID(/* parameters */);
    }

    /**
     * Tests OperationCategorie::checkTitle()
     */
    public function testCheckTitle()
    {
        // TODO Auto-generated OperationCategorieTest::testCheckTitle()
        $this->markTestIncomplete("checkTitle test not implemented");
        
        OperationCategorie::checkTitle(/* parameters */);
    }

    /**
     * Tests OperationCategorie::checkDescription()
     */
    public function testCheckDescription()
    {
        // TODO Auto-generated OperationCategorieTest::testCheckDescription()
        $this->markTestIncomplete("checkDescription test not implemented");
        
        OperationCategorie::checkDescription(/* parameters */);
    }

    /**
     * Tests OperationCategorie::getByID()
     */
    public function testGetByID()
    {
        // TODO Auto-generated OperationCategorieTest::testGetByID()
        $this->markTestIncomplete("getByID test not implemented");
        
        OperationCategorie::getByID(/* parameters */);
    }

    /**
     * Tests OperationCategorie->newCategorie()
     */
    public function testNewCategorie()
    {
        // TODO Auto-generated OperationCategorieTest->testNewCategorie()
        $this->markTestIncomplete("newCategorie test not implemented");
        
        $this->OperationCategorie->newCategorie(/* parameters */);
    }

    /**
     * Tests OperationCategorie->changeTitle()
     */
    public function testChangeTitle()
    {
        // TODO Auto-generated OperationCategorieTest->testChangeTitle()
        $this->markTestIncomplete("changeTitle test not implemented");
        
        $this->OperationCategorie->changeTitle(/* parameters */);
    }

    /**
     * Tests OperationCategorie->changeDescription()
     */
    public function testChangeDescription()
    {
        // TODO Auto-generated OperationCategorieTest->testChangeDescription()
        $this->markTestIncomplete("changeDescription test not implemented");
        
        $this->OperationCategorie->changeDescription(/* parameters */);
    }

    /**
     * Tests OperationCategorie->deleteCategorie()
     */
    public function testDeleteCategorie()
    {
        // TODO Auto-generated OperationCategorieTest->testDeleteCategorie()
        $this->markTestIncomplete("deleteCategorie test not implemented");
        
        $this->OperationCategorie->deleteCategorie(/* parameters */);
    }

    /**
     * Tests OperationCategorie::getAll()
     */
    public function testGetAll()
    {
        // TODO Auto-generated OperationCategorieTest::testGetAll()
        $this->markTestIncomplete("getAll test not implemented");
        
        OperationCategorie::getAll(/* parameters */);
    }

    /**
     * Tests OperationCategorie->getID()
     */
    public function testGetID()
    {
        // TODO Auto-generated OperationCategorieTest->testGetID()
        $this->markTestIncomplete("getID test not implemented");
        
        $this->OperationCategorie->getID(/* parameters */);
    }

    /**
     * Tests OperationCategorie->getTitle()
     */
    public function testGetTitle()
    {
        // TODO Auto-generated OperationCategorieTest->testGetTitle()
        $this->markTestIncomplete("getTitle test not implemented");
        
        $this->OperationCategorie->getTitle(/* parameters */);
    }

    /**
     * Tests OperationCategorie->getDescription()
     */
    public function testGetDescription()
    {
        // TODO Auto-generated OperationCategorieTest->testGetDescription()
        $this->markTestIncomplete("getDescription test not implemented");
        
        $this->OperationCategorie->getDescription(/* parameters */);
    }

    /**
     * Tests OperationCategorie->getOperations()
     */
    public function testGetOperations()
    {
        // TODO Auto-generated OperationCategorieTest->testGetOperations()
        $this->markTestIncomplete("getOperations test not implemented");
        
        $this->OperationCategorie->getOperations(/* parameters */);
    }

    /**
     * Tests OperationCategorie->toArray()
     */
    public function testToArray()
    {
        // TODO Auto-generated OperationCategorieTest->testToArray()
        $this->markTestIncomplete("toArray test not implemented");
        
        $this->OperationCategorie->toArray(/* parameters */);
    }
}

