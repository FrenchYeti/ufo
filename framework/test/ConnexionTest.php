<?php
require_once 'UFO/Db/Connexion.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Connexion test case.
 */
class ConnexionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Connexion
     */
    private $Connexion;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated ConnexionTest::setUp()
        
        $this->Connexion = new Connexion(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ConnexionTest::tearDown()
        $this->Connexion = null;
        
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
     * Tests Connexion->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated ConnexionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->Connexion->__construct(/* parameters */);
    }

    /**
     * Tests Connexion->__clone()
     */
    public function test__clone()
    {
        // TODO Auto-generated ConnexionTest->test__clone()
        $this->markTestIncomplete("__clone test not implemented");
        
        $this->Connexion->__clone(/* parameters */);
    }

    /**
     * Tests Connexion->__destruct()
     */
    public function test__destruct()
    {
        // TODO Auto-generated ConnexionTest->test__destruct()
        $this->markTestIncomplete("__destruct test not implemented");
        
        $this->Connexion->__destruct(/* parameters */);
    }

    /**
     * Tests Connexion->getHandler()
     */
    public function testGetHandler()
    {
        // TODO Auto-generated ConnexionTest->testGetHandler()
        $this->markTestIncomplete("getHandler test not implemented");
        
        $this->Connexion->getHandler(/* parameters */);
    }

    /**
     * Tests Connexion->manageCase()
     */
    public function testManageCase()
    {
        // TODO Auto-generated ConnexionTest->testManageCase()
        $this->markTestIncomplete("manageCase test not implemented");
        
        $this->Connexion->manageCase(/* parameters */);
    }

    /**
     * Tests Connexion->lastInsertId()
     */
    public function testLastInsertId()
    {
        // TODO Auto-generated ConnexionTest->testLastInsertId()
        $this->markTestIncomplete("lastInsertId test not implemented");
        
        $this->Connexion->lastInsertId(/* parameters */);
    }

    /**
     * Tests Connexion->SQL()
     */
    public function testSQL()
    {
        // TODO Auto-generated ConnexionTest->testSQL()
        $this->markTestIncomplete("SQL test not implemented");
        
        $this->Connexion->SQL(/* parameters */);
    }

    /**
     * Tests Connexion->query()
     */
    public function testQuery()
    {
        // TODO Auto-generated ConnexionTest->testQuery()
        $this->markTestIncomplete("query test not implemented");
        
        $this->Connexion->query(/* parameters */);
    }

    /**
     * Tests Connexion->exec()
     */
    public function testExec()
    {
        // TODO Auto-generated ConnexionTest->testExec()
        $this->markTestIncomplete("exec test not implemented");
        
        $this->Connexion->exec(/* parameters */);
    }

    /**
     * Tests Connexion->prepare()
     */
    public function testPrepare()
    {
        // TODO Auto-generated ConnexionTest->testPrepare()
        $this->markTestIncomplete("prepare test not implemented");
        
        $this->Connexion->prepare(/* parameters */);
    }
}

