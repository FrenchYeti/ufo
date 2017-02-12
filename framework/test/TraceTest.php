<?php
require_once 'tests/Log/Trace.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Trace test case.
 */
class TraceTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Trace
     */
    private $Trace;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated TraceTest::setUp()
        
        $this->Trace = new Trace(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated TraceTest::tearDown()
        $this->Trace = null;
        
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
     * Tests Trace::add()
     */
    public function testAdd()
    {
        // TODO Auto-generated TraceTest::testAdd()
        $this->markTestIncomplete("add test not implemented");
        
        Trace::add(/* parameters */);
    }

    /**
     * Tests Trace::dumpHTML()
     */
    public function testDumpHTML()
    {
        // TODO Auto-generated TraceTest::testDumpHTML()
        $this->markTestIncomplete("dumpHTML test not implemented");
        
        Trace::dumpHTML(/* parameters */);
    }

    /**
     * Tests Trace::addDebugData()
     */
    public function testAddDebugData()
    {
        // TODO Auto-generated TraceTest::testAddDebugData()
        $this->markTestIncomplete("addDebugData test not implemented");
        
        Trace::addDebugData(/* parameters */);
    }

    /**
     * Tests Trace::issetDebugData()
     */
    public function testIssetDebugData()
    {
        // TODO Auto-generated TraceTest::testIssetDebugData()
        $this->markTestIncomplete("issetDebugData test not implemented");
        
        Trace::issetDebugData(/* parameters */);
    }

    /**
     * Tests Trace::dumpDebugData()
     */
    public function testDumpDebugData()
    {
        // TODO Auto-generated TraceTest::testDumpDebugData()
        $this->markTestIncomplete("dumpDebugData test not implemented");
        
        Trace::dumpDebugData(/* parameters */);
    }

    /**
     * Tests Trace::truncate()
     */
    public function testTruncate()
    {
        // TODO Auto-generated TraceTest::testTruncate()
        $this->markTestIncomplete("truncate test not implemented");
        
        Trace::truncate(/* parameters */);
    }
}

