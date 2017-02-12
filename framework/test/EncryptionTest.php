<?php
require_once 'UFO/Crypto/ConfidentialString.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Encryption test case.
 */
class EncryptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Encryption
     */
    private $Encryption;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated EncryptionTest::setUp()
        
        $this->Encryption = new Encryption(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated EncryptionTest::tearDown()
        $this->Encryption = null;
        
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
     * Tests Encryption::getCipher()
     */
    public function testGetCipher()
    {
        // TODO Auto-generated EncryptionTest::testGetCipher()
        $this->markTestIncomplete("getCipher test not implemented");
        
        Encryption::getCipher(/* parameters */);
    }

    /**
     * Tests Encryption::getKey()
     */
    public function testGetKey()
    {
        // TODO Auto-generated EncryptionTest::testGetKey()
        $this->markTestIncomplete("getKey test not implemented");
        
        Encryption::getKey(/* parameters */);
    }

    /**
     * Tests Encryption::getMode()
     */
    public function testGetMode()
    {
        // TODO Auto-generated EncryptionTest::testGetMode()
        $this->markTestIncomplete("getMode test not implemented");
        
        Encryption::getMode(/* parameters */);
    }

    /**
     * Tests Encryption::getIV()
     */
    public function testGetIV()
    {
        // TODO Auto-generated EncryptionTest::testGetIV()
        $this->markTestIncomplete("getIV test not implemented");
        
        Encryption::getIV(/* parameters */);
    }
}

