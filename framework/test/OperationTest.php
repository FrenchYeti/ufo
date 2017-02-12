<?php
require_once 'tests/RBAC/Operation.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Operation test case.
 */
class OperationTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Operation
     */
    private $Operation;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated OperationTest::setUp()
        
        $this->Operation = new Operation(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated OperationTest::tearDown()
        $this->Operation = null;
        
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
     * Tests Operation::checkID()
     */
    public function testCheckID()
    {
        // TODO Auto-generated OperationTest::testCheckID()
        $this->markTestIncomplete("checkID test not implemented");
        
        Operation::checkID(/* parameters */);
    }

    /**
     * Tests Operation::checkTitle()
     */
    public function testCheckTitle()
    {
        // TODO Auto-generated OperationTest::testCheckTitle()
        $this->markTestIncomplete("checkTitle test not implemented");
        
        Operation::checkTitle(/* parameters */);
    }

    /**
     * Tests Operation::checkDescription()
     */
    public function testCheckDescription()
    {
        // TODO Auto-generated OperationTest::testCheckDescription()
        $this->markTestIncomplete("checkDescription test not implemented");
        
        Operation::checkDescription(/* parameters */);
    }

    /**
     * Tests Operation::checkTitleAsUniqueIndex()
     */
    public function testCheckTitleAsUniqueIndex()
    {
        // TODO Auto-generated OperationTest::testCheckTitleAsUniqueIndex()
        $this->markTestIncomplete("checkTitleAsUniqueIndex test not implemented");
        
        Operation::checkTitleAsUniqueIndex(/* parameters */);
    }

    /**
     * Tests Operation->newOperation()
     */
    public function testNewOperation()
    {
        // TODO Auto-generated OperationTest->testNewOperation()
        $this->markTestIncomplete("newOperation test not implemented");
        
        $this->Operation->newOperation(/* parameters */);
    }

    /**
     * Tests Operation->changeCategorie()
     */
    public function testChangeCategorie()
    {
        // TODO Auto-generated OperationTest->testChangeCategorie()
        $this->markTestIncomplete("changeCategorie test not implemented");
        
        $this->Operation->changeCategorie(/* parameters */);
    }

    /**
     * Tests Operation->deleteOperation()
     */
    public function testDeleteOperation()
    {
        // TODO Auto-generated OperationTest->testDeleteOperation()
        $this->markTestIncomplete("deleteOperation test not implemented");
        
        $this->Operation->deleteOperation(/* parameters */);
    }

    /**
     * Tests Operation->getTitle()
     */
    public function testGetTitle()
    {
        // TODO Auto-generated OperationTest->testGetTitle()
        $this->markTestIncomplete("getTitle test not implemented");
        
        $this->Operation->getTitle(/* parameters */);
    }

    /**
     * Tests Operation->setTitle()
     */
    public function testSetTitle()
    {
        // TODO Auto-generated OperationTest->testSetTitle()
        $this->markTestIncomplete("setTitle test not implemented");
        
        $this->Operation->setTitle(/* parameters */);
    }

    /**
     * Tests Operation::getAll()
     */
    public function testGetAll()
    {
        // TODO Auto-generated OperationTest::testGetAll()
        $this->markTestIncomplete("getAll test not implemented");
        
        Operation::getAll(/* parameters */);
    }

    /**
     * Tests Operation::getByID()
     */
    public function testGetByID()
    {
        // TODO Auto-generated OperationTest::testGetByID()
        $this->markTestIncomplete("getByID test not implemented");
        
        Operation::getByID(/* parameters */);
    }

    /**
     * Tests Operation::getByName()
     */
    public function testGetByName()
    {
        // TODO Auto-generated OperationTest::testGetByName()
        $this->markTestIncomplete("getByName test not implemented");
        
        Operation::getByName(/* parameters */);
    }

    /**
     * Tests Operation->getID()
     */
    public function testGetID()
    {
        // TODO Auto-generated OperationTest->testGetID()
        $this->markTestIncomplete("getID test not implemented");
        
        $this->Operation->getID(/* parameters */);
    }

    /**
     * Tests Operation::instanciate()
     */
    public function testInstanciate()
    {
        // TODO Auto-generated OperationTest::testInstanciate()
        $this->markTestIncomplete("instanciate test not implemented");
        
        Operation::instanciate(/* parameters */);
    }

    /**
     * Tests Operation::getFromCategorie()
     */
    public function testGetFromCategorie()
    {
        // TODO Auto-generated OperationTest::testGetFromCategorie()
        $this->markTestIncomplete("getFromCategorie test not implemented");
        
        Operation::getFromCategorie(/* parameters */);
    }

    /**
     * Tests Operation->getCategorieName()
     */
    public function testGetCategorieName()
    {
        // TODO Auto-generated OperationTest->testGetCategorieName()
        $this->markTestIncomplete("getCategorieName test not implemented");
        
        $this->Operation->getCategorieName(/* parameters */);
    }

    /**
     * Tests Operation->getAuthorizations()
     */
    public function testGetAuthorizations()
    {
        // TODO Auto-generated OperationTest->testGetAuthorizations()
        $this->markTestIncomplete("getAuthorizations test not implemented");
        
        $this->Operation->getAuthorizations(/* parameters */);
    }

    /**
     * Tests Operation->toArray()
     */
    public function testToArray()
    {
        // TODO Auto-generated OperationTest->testToArray()
        $this->markTestIncomplete("toArray test not implemented");
        
        $this->Operation->toArray(/* parameters */);
    }
}

