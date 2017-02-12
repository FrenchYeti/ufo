<?php
require_once 'tests/HTTP/Tainted.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Tainted test case.
 */
class TaintedTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Tainted
     */
    private $Tainted;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated TaintedTest::setUp()
        
        $this->Tainted = new Tainted(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated TaintedTest::tearDown()
        $this->Tainted = null;
        
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
     * Tests Tainted::Is()
     */
    public function testIs()
    {
        // TODO Auto-generated TaintedTest::testIs()
        $this->markTestIncomplete("Is test not implemented");
        
        Tainted::Is(/* parameters */);
    }

    /**
     * Tests Tainted->decontaminate()
     */
    public function testDecontaminate()
    {
        // TODO Auto-generated TaintedTest->testDecontaminate()
        $this->markTestIncomplete("decontaminate test not implemented");
        
        $this->Tainted->decontaminate(/* parameters */);
    }

    /**
     * Tests Tainted->contaminate()
     */
    public function testContaminate()
    {
        // TODO Auto-generated TaintedTest->testContaminate()
        $this->markTestIncomplete("contaminate test not implemented");
        
        $this->Tainted->contaminate(/* parameters */);
    }
}

