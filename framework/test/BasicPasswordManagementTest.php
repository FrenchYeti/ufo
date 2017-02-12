<?php
require_once 'tests/Security/BasicPasswordManagement.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * BasicPasswordManagement test case.
 */
class BasicPasswordManagementTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var BasicPasswordManagement
     */
    private $BasicPasswordManagement;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated BasicPasswordManagementTest::setUp()
        
        $this->BasicPasswordManagement = new BasicPasswordManagement(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated BasicPasswordManagementTest::tearDown()
        $this->BasicPasswordManagement = null;
        
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
     * Tests BasicPasswordManagement::getStaticSalt()
     */
    public function testGetStaticSalt()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testGetStaticSalt()
        $this->markTestIncomplete("getStaticSalt test not implemented");
        
        BasicPasswordManagement::getStaticSalt(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::Entropy()
     */
    public function testEntropy()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testEntropy()
        $this->markTestIncomplete("Entropy test not implemented");
        
        BasicPasswordManagement::Entropy(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::hasOrderedCharacters()
     */
    public function testHasOrderedCharacters()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testHasOrderedCharacters()
        $this->markTestIncomplete("hasOrderedCharacters test not implemented");
        
        BasicPasswordManagement::hasOrderedCharacters(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::hasKeyboardOrderedCharacters()
     */
    public function testHasKeyboardOrderedCharacters()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testHasKeyboardOrderedCharacters()
        $this->markTestIncomplete("hasKeyboardOrderedCharacters test not implemented");
        
        BasicPasswordManagement::hasKeyboardOrderedCharacters(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::isPhoneNumber()
     */
    public function testIsPhoneNumber()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testIsPhoneNumber()
        $this->markTestIncomplete("isPhoneNumber test not implemented");
        
        BasicPasswordManagement::isPhoneNumber(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::containsPhoneNumber()
     */
    public function testContainsPhoneNumber()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testContainsPhoneNumber()
        $this->markTestIncomplete("containsPhoneNumber test not implemented");
        
        BasicPasswordManagement::containsPhoneNumber(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::isDate()
     */
    public function testIsDate()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testIsDate()
        $this->markTestIncomplete("isDate test not implemented");
        
        BasicPasswordManagement::isDate(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::containsDate()
     */
    public function testContainsDate()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testContainsDate()
        $this->markTestIncomplete("containsDate test not implemented");
        
        BasicPasswordManagement::containsDate(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::containDoubledWords()
     */
    public function testContainDoubledWords()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testContainDoubledWords()
        $this->markTestIncomplete("containDoubledWords test not implemented");
        
        BasicPasswordManagement::containDoubledWords(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::containsString()
     */
    public function testContainsString()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testContainsString()
        $this->markTestIncomplete("containsString test not implemented");
        
        BasicPasswordManagement::containsString(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::strength()
     */
    public function testStrength()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testStrength()
        $this->markTestIncomplete("strength test not implemented");
        
        BasicPasswordManagement::strength(/* parameters */);
    }

    /**
     * Tests BasicPasswordManagement::generate()
     */
    public function testGenerate()
    {
        // TODO Auto-generated BasicPasswordManagementTest::testGenerate()
        $this->markTestIncomplete("generate test not implemented");
        
        BasicPasswordManagement::generate(/* parameters */);
    }
}

