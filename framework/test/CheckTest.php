<?php
require_once 'UFO/Security/Check.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Check test case.
 */
class CheckTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Check
     */
    private $Check;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
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
     * Tests Check::pureText()
     */
    public function testPureText()
    {
        // TODO Auto-generated CheckTest::testPureText()
        $this->markTestIncomplete("pureText test not implemented");
        
        $this->assertTrue( Check::pureText('troll',false,false,10));
        $this->assertTrue( Check::pureText('troll',false,false,5));
        $this->assertFalse( Check::pureText('troll',false,false,3));
        $this->assertFalse( Check::pureText('troll',false,false,3));
        
    }

    /**
     * Tests Check::specificPureText()
     */
    public function testSpecificPureText()
    {
        // TODO Auto-generated CheckTest::testSpecificPureText()
        $this->markTestIncomplete("specificPureText test not implemented");
        
        Check::specificPureText(/* parameters */);
    }

    /**
     * Tests Check::litteralI18nText()
     */
    public function testLitteralI18nText()
    {
        // TODO Auto-generated CheckTest::testLitteralI18nText()
        $this->markTestIncomplete("litteralI18nText test not implemented");
        
        Check::litteralI18nText(/* parameters */);
    }

    /**
     * Tests Check::punctuatedText()
     */
    public function testPunctuatedText()
    {
        // TODO Auto-generated CheckTest::testPunctuatedText()
        $this->markTestIncomplete("punctuatedText test not implemented");
        
        Check::punctuatedText(/* parameters */);
    }

    /**
     * Tests Check::specificPunctuatedText()
     */
    public function testSpecificPunctuatedText()
    {
        // TODO Auto-generated CheckTest::testSpecificPunctuatedText()
        $this->markTestIncomplete("specificPunctuatedText test not implemented");
        
        Check::specificPunctuatedText(/* parameters */);
    }

    /**
     * Tests Check::htmlText()
     */
    public function testHtmlText()
    {
        // TODO Auto-generated CheckTest::testHtmlText()
        $this->markTestIncomplete("htmlText test not implemented");
        
        Check::htmlText(/* parameters */);
    }

    /**
     * Tests Check::mailText()
     */
    public function testMailText()
    {
        // TODO Auto-generated CheckTest::testMailText()
        $this->markTestIncomplete("mailText test not implemented");
        
        Check::mailText(/* parameters */);
    }

    /**
     * Tests Check::wwwText()
     */
    public function testWwwText()
    {
        // TODO Auto-generated CheckTest::testWwwText()
        $this->markTestIncomplete("wwwText test not implemented");
        
        Check::wwwText(/* parameters */);
    }

    /**
     * Tests Check::dateText()
     */
    public function testDateText()
    {
        // TODO Auto-generated CheckTest::testDateText()
        $this->markTestIncomplete("dateText test not implemented");
        
        Check::dateText(/* parameters */);
    }

    /**
     * Tests Check::dateFormatText()
     */
    public function testDateFormatText()
    {
        // TODO Auto-generated CheckTest::testDateFormatText()
        $this->markTestIncomplete("dateFormatText test not implemented");
        
        Check::dateFormatText(/* parameters */);
    }

    /**
     * Tests Check::numberText()
     */
    public function testNumberText()
    {
        // TODO Auto-generated CheckTest::testNumberText()
        $this->markTestIncomplete("numberText test not implemented");
        
        Check::numberText(/* parameters */);
    }

    /**
     * Tests Check::specificNumberText()
     */
    public function testSpecificNumberText()
    {
        // TODO Auto-generated CheckTest::testSpecificNumberText()
        $this->markTestIncomplete("specificNumberText test not implemented");
        
        Check::specificNumberText(/* parameters */);
    }

    /**
     * Tests Check::shortInt()
     */
    public function testShortInt()
    {
        // TODO Auto-generated CheckTest::testShortInt()
        $this->markTestIncomplete("shortInt test not implemented");
        
        Check::shortInt(/* parameters */);
    }

    /**
     * Tests Check::hexadecimalText()
     */
    public function testHexadecimalText()
    {
        // TODO Auto-generated CheckTest::testHexadecimalText()
        $this->markTestIncomplete("hexadecimalText test not implemented");
        
        Check::hexadecimalText(/* parameters */);
    }

    /**
     * Tests Check::phptestCallback()
     */
    public function testPhptestCallback()
    {
        // TODO Auto-generated CheckTest::testPhptestCallback()
        $this->markTestIncomplete("phptestCallback test not implemented");
        
        Check::phptestCallback(/* parameters */);
    }

    /**
     * Tests Check::arrayText()
     */
    public function testArrayText()
    {
        // TODO Auto-generated CheckTest::testArrayText()
        $this->markTestIncomplete("arrayText test not implemented");
        
        Check::arrayText(/* parameters */);
    }

    /**
     * Tests Check::asObjectProperty()
     */
    public function testAsObjectProperty()
    {
        // TODO Auto-generated CheckTest::testAsObjectProperty()
        $this->markTestIncomplete("asObjectProperty test not implemented");
        
        Check::asObjectProperty(/* parameters */);
    }

    /**
     * Tests Check::decimal()
     */
    public function testDecimal()
    {
        // TODO Auto-generated CheckTest::testDecimal()
        $this->markTestIncomplete("decimal test not implemented");
        
        Check::decimal(/* parameters */);
    }
}

