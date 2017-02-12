<?php
require_once 'UFO/Db/Statement.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Statement test case.
 */
class StatementTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Statement
     */
    private $Statement;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated StatementTest::setUp()
        
        $this->Statement = new Statement(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated StatementTest::tearDown()
        $this->Statement = null;
        
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
     * Tests Statement->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated StatementTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->Statement->__construct(/* parameters */);
    }

    /**
     * Tests Statement->__destruct()
     */
    public function test__destruct()
    {
        // TODO Auto-generated StatementTest->test__destruct()
        $this->markTestIncomplete("__destruct test not implemented");
        
        $this->Statement->__destruct(/* parameters */);
    }

    /**
     * Tests Statement->fetch()
     */
    public function testFetch()
    {
        // TODO Auto-generated StatementTest->testFetch()
        $this->markTestIncomplete("fetch test not implemented");
        
        $this->Statement->fetch(/* parameters */);
    }

    /**
     * Tests Statement->fetchAll()
     */
    public function testFetchAll()
    {
        // TODO Auto-generated StatementTest->testFetchAll()
        $this->markTestIncomplete("fetchAll test not implemented");
        
        $this->Statement->fetchAll(/* parameters */);
    }

    /**
     * Tests Statement->bindAll()
     */
    public function testBindAll()
    {
        // TODO Auto-generated StatementTest->testBindAll()
        $this->markTestIncomplete("bindAll test not implemented");
        
        $this->Statement->bindAll(/* parameters */);
    }

    /**
     * Tests Statement->execute()
     */
    public function testExecute()
    {
        // TODO Auto-generated StatementTest->testExecute()
        $this->markTestIncomplete("execute test not implemented");
        
        $this->Statement->execute(/* parameters */);
    }

    /**
     * Tests Statement->rowCount()
     */
    public function testRowCount()
    {
        // TODO Auto-generated StatementTest->testRowCount()
        $this->markTestIncomplete("rowCount test not implemented");
        
        $this->Statement->rowCount(/* parameters */);
    }
}

