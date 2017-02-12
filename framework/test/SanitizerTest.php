<?php
require_once 'tests/Security/Sanitizer.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Sanitizer test case.
 */
class SanitizerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Sanitizer
     */
    private $Sanitizer;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated SanitizerTest::setUp()
        
        $this->Sanitizer = new Sanitizer(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated SanitizerTest::tearDown()
        $this->Sanitizer = null;
        
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
     * Tests Sanitizer::on()
     */
    public function testOn()
    {
        // TODO Auto-generated SanitizerTest::testOn()
        $this->markTestIncomplete("on test not implemented");
        
        Sanitizer::on(/* parameters */);
    }

    /**
     * Tests Sanitizer->asInteger()
     */
    public function testAsInteger()
    {
        // TODO Auto-generated SanitizerTest->testAsInteger()
        $this->markTestIncomplete("asInteger test not implemented");
        
        $this->Sanitizer->asInteger(/* parameters */);
    }

    /**
     * Tests Sanitizer->asFloat()
     */
    public function testAsFloat()
    {
        // TODO Auto-generated SanitizerTest->testAsFloat()
        $this->markTestIncomplete("asFloat test not implemented");
        
        $this->Sanitizer->asFloat(/* parameters */);
    }

    /**
     * Tests Sanitizer->asString()
     */
    public function testAsString()
    {
        // TODO Auto-generated SanitizerTest->testAsString()
        $this->markTestIncomplete("asString test not implemented");
        
        $this->Sanitizer->asString(/* parameters */);
    }

    /**
     * Tests Sanitizer->remakeAsPureText()
     */
    public function testRemakeAsPureText()
    {
        // TODO Auto-generated SanitizerTest->testRemakeAsPureText()
        $this->markTestIncomplete("remakeAsPureText test not implemented");
        
        $this->Sanitizer->remakeAsPureText(/* parameters */);
    }

    /**
     * Tests Sanitizer->removeSimpleQuotes()
     */
    public function testRemoveSimpleQuotes()
    {
        // TODO Auto-generated SanitizerTest->testRemoveSimpleQuotes()
        $this->markTestIncomplete("removeSimpleQuotes test not implemented");
        
        $this->Sanitizer->removeSimpleQuotes(/* parameters */);
    }

    /**
     * Tests Sanitizer->removeDoubleQuotes()
     */
    public function testRemoveDoubleQuotes()
    {
        // TODO Auto-generated SanitizerTest->testRemoveDoubleQuotes()
        $this->markTestIncomplete("removeDoubleQuotes test not implemented");
        
        $this->Sanitizer->removeDoubleQuotes(/* parameters */);
    }

    /**
     * Tests Sanitizer->get()
     */
    public function testGet()
    {
        // TODO Auto-generated SanitizerTest->testGet()
        $this->markTestIncomplete("get test not implemented");
        
        $this->Sanitizer->get(/* parameters */);
    }

    /**
     * Tests Sanitizer->withCheck()
     */
    public function testWithCheck()
    {
        // TODO Auto-generated SanitizerTest->testWithCheck()
        $this->markTestIncomplete("withCheck test not implemented");
        
        $this->Sanitizer->withCheck(/* parameters */);
    }

    /**
     * Tests Sanitizer->withRegexp()
     */
    public function testWithRegexp()
    {
        // TODO Auto-generated SanitizerTest->testWithRegexp()
        $this->markTestIncomplete("withRegexp test not implemented");
        
        $this->Sanitizer->withRegexp(/* parameters */);
    }
}

