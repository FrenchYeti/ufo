<?php
require_once 'tests/HTTP/TaintedInputs.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * TaintedInputs test case.
 */
class TaintedInputsTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var TaintedInputs
     */
    private $TaintedInputs;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated TaintedInputsTest::setUp()
        
        $this->TaintedInputs = new TaintedInputs(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated TaintedInputsTest::tearDown()
        $this->TaintedInputs = null;
        
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
     * Tests TaintedInputs->is_submit()
     */
    public function testIs_submit()
    {
        // TODO Auto-generated TaintedInputsTest->testIs_submit()
        $this->markTestIncomplete("is_submit test not implemented");
        
        $this->TaintedInputs->is_submit(/* parameters */);
    }

    /**
     * Tests TaintedInputs->is_empty()
     */
    public function testIs_empty()
    {
        // TODO Auto-generated TaintedInputsTest->testIs_empty()
        $this->markTestIncomplete("is_empty test not implemented");
        
        $this->TaintedInputs->is_empty(/* parameters */);
    }

    /**
     * Tests TaintedInputs->sanitizeWithCheck()
     */
    public function testSanitizeWithCheck()
    {
        // TODO Auto-generated TaintedInputsTest->testSanitizeWithCheck()
        $this->markTestIncomplete("sanitizeWithCheck test not implemented");
        
        $this->TaintedInputs->sanitizeWithCheck(/* parameters */);
    }

    /**
     * Tests TaintedInputs->sanitizeAsObjectProperty()
     */
    public function testSanitizeAsObjectProperty()
    {
        // TODO Auto-generated TaintedInputsTest->testSanitizeAsObjectProperty()
        $this->markTestIncomplete("sanitizeAsObjectProperty test not implemented");
        
        $this->TaintedInputs->sanitizeAsObjectProperty(/* parameters */);
    }

    /**
     * Tests TaintedInputs->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated TaintedInputsTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->TaintedInputs->__construct(/* parameters */);
    }

    /**
     * Tests TaintedInputs->__call()
     */
    public function test__call()
    {
        // TODO Auto-generated TaintedInputsTest->test__call()
        $this->markTestIncomplete("__call test not implemented");
        
        $this->TaintedInputs->__call(/* parameters */);
    }
}

