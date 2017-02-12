<?php
require_once 'tests/Security/Ring.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Ring test case.
 */
class RingTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Ring
     */
    private $Ring;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated RingTest::setUp()
        
        $this->Ring = new Ring(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated RingTest::tearDown()
        $this->Ring = null;
        
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
     * Tests Ring->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated RingTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->Ring->__construct(/* parameters */);
    }

    /**
     * Tests Ring::existingToken()
     */
    public function testExistingToken()
    {
        // TODO Auto-generated RingTest::testExistingToken()
        $this->markTestIncomplete("existingToken test not implemented");
        
        Ring::existingToken(/* parameters */);
    }

    /**
     * Tests Ring::expiredToken()
     */
    public function testExpiredToken()
    {
        // TODO Auto-generated RingTest::testExpiredToken()
        $this->markTestIncomplete("expiredToken test not implemented");
        
        Ring::expiredToken(/* parameters */);
    }

    /**
     * Tests Ring->newRing()
     */
    public function testNewRing()
    {
        // TODO Auto-generated RingTest->testNewRing()
        $this->markTestIncomplete("newRing test not implemented");
        
        $this->Ring->newRing(/* parameters */);
    }

    /**
     * Tests Ring->getToken()
     */
    public function testGetToken()
    {
        // TODO Auto-generated RingTest->testGetToken()
        $this->markTestIncomplete("getToken test not implemented");
        
        $this->Ring->getToken(/* parameters */);
    }

    /**
     * Tests Ring->remove()
     */
    public function testRemove()
    {
        // TODO Auto-generated RingTest->testRemove()
        $this->markTestIncomplete("remove test not implemented");
        
        $this->Ring->remove(/* parameters */);
    }

    /**
     * Tests Ring->setData()
     */
    public function testSetData()
    {
        // TODO Auto-generated RingTest->testSetData()
        $this->markTestIncomplete("setData test not implemented");
        
        $this->Ring->setData(/* parameters */);
    }

    /**
     * Tests Ring::loadRing()
     */
    public function testLoadRing()
    {
        // TODO Auto-generated RingTest::testLoadRing()
        $this->markTestIncomplete("loadRing test not implemented");
        
        Ring::loadRing(/* parameters */);
    }

    /**
     * Tests Ring->old_loadRing()
     */
    public function testOld_loadRing()
    {
        // TODO Auto-generated RingTest->testOld_loadRing()
        $this->markTestIncomplete("old_loadRing test not implemented");
        
        $this->Ring->old_loadRing(/* parameters */);
    }

    /**
     * Tests Ring->getData()
     */
    public function testGetData()
    {
        // TODO Auto-generated RingTest->testGetData()
        $this->markTestIncomplete("getData test not implemented");
        
        $this->Ring->getData(/* parameters */);
    }

    /**
     * Tests Ring->old_getData()
     */
    public function testOld_getData()
    {
        // TODO Auto-generated RingTest->testOld_getData()
        $this->markTestIncomplete("old_getData test not implemented");
        
        $this->Ring->old_getData(/* parameters */);
    }

    /**
     * Tests Ring->getFieldname()
     */
    public function testGetFieldname()
    {
        // TODO Auto-generated RingTest->testGetFieldname()
        $this->markTestIncomplete("getFieldname test not implemented");
        
        $this->Ring->getFieldname(/* parameters */);
    }

    /**
     * Tests Ring->getKeyRing()
     */
    public function testGetKeyRing()
    {
        // TODO Auto-generated RingTest->testGetKeyRing()
        $this->markTestIncomplete("getKeyRing test not implemented");
        
        $this->Ring->getKeyRing(/* parameters */);
    }

    /**
     * Tests Ring->getKeyRingFieldname()
     */
    public function testGetKeyRingFieldname()
    {
        // TODO Auto-generated RingTest->testGetKeyRingFieldname()
        $this->markTestIncomplete("getKeyRingFieldname test not implemented");
        
        $this->Ring->getKeyRingFieldname(/* parameters */);
    }

    /**
     * Tests Ring->destroy()
     */
    public function testDestroy()
    {
        // TODO Auto-generated RingTest->testDestroy()
        $this->markTestIncomplete("destroy test not implemented");
        
        $this->Ring->destroy(/* parameters */);
    }

    /**
     * Tests Ring->checkKeyRingFormat()
     */
    public function testCheckKeyRingFormat()
    {
        // TODO Auto-generated RingTest->testCheckKeyRingFormat()
        $this->markTestIncomplete("checkKeyRingFormat test not implemented");
        
        $this->Ring->checkKeyRingFormat(/* parameters */);
    }

    /**
     * Tests Ring::sanitizeKeyRing()
     */
    public function testSanitizeKeyRing()
    {
        // TODO Auto-generated RingTest::testSanitizeKeyRing()
        $this->markTestIncomplete("sanitizeKeyRing test not implemented");
        
        Ring::sanitizeKeyRing(/* parameters */);
    }

    /**
     * Tests Ring::sanitizeKeyFieldname()
     */
    public function testSanitizeKeyFieldname()
    {
        // TODO Auto-generated RingTest::testSanitizeKeyFieldname()
        $this->markTestIncomplete("sanitizeKeyFieldname test not implemented");
        
        Ring::sanitizeKeyFieldname(/* parameters */);
    }
}

