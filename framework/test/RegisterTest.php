<?php
require_once 'tests/Form/Register.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Register test case.
 */
class RegisterTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Register
     */
    private $Register;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated RegisterTest::setUp()
        
        $this->Register = new Register(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated RegisterTest::tearDown()
        $this->Register = null;
        
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
     * Tests Register::getInstance()
     */
    public function testGetInstance()
    {
        // TODO Auto-generated RegisterTest::testGetInstance()
        $this->markTestIncomplete("getInstance test not implemented");
        
        Register::getInstance(/* parameters */);
    }

    /**
     * Tests Register->save()
     */
    public function testSave()
    {
        // TODO Auto-generated RegisterTest->testSave()
        $this->markTestIncomplete("save test not implemented");
        
        $this->Register->save(/* parameters */);
    }

    /**
     * Tests Register::getForm()
     */
    public function testGetForm()
    {
        // TODO Auto-generated RegisterTest::testGetForm()
        $this->markTestIncomplete("getForm test not implemented");
        
        Register::getForm(/* parameters */);
    }

    /**
     * Tests Register::addForm()
     */
    public function testAddForm()
    {
        // TODO Auto-generated RegisterTest::testAddForm()
        $this->markTestIncomplete("addForm test not implemented");
        
        Register::addForm(/* parameters */);
    }

    /**
     * Tests Register::removeForm()
     */
    public function testRemoveForm()
    {
        // TODO Auto-generated RegisterTest::testRemoveForm()
        $this->markTestIncomplete("removeForm test not implemented");
        
        Register::removeForm(/* parameters */);
    }

    /**
     * Tests Register::truncate()
     */
    public function testTruncate()
    {
        // TODO Auto-generated RegisterTest::testTruncate()
        $this->markTestIncomplete("truncate test not implemented");
        
        Register::truncate(/* parameters */);
    }
}

