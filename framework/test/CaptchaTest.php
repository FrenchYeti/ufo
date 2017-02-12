<?php
require_once 'UFO/Captcha/Captcha.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Captcha test case.
 */
class CaptchaTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Captcha
     */
    private $Captcha;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated CaptchaTest::setUp()
        
        $this->Captcha = new Captcha(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated CaptchaTest::tearDown()
        $this->Captcha = null;
        
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
     * Tests Captcha->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated CaptchaTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->Captcha->__construct(/* parameters */);
    }

    /**
     * Tests Captcha->getValue()
     */
    public function testGetValue()
    {
        // TODO Auto-generated CaptchaTest->testGetValue()
        $this->markTestIncomplete("getValue test not implemented");
        
        $this->Captcha->getValue(/* parameters */);
    }

    /**
     * Tests Captcha->getClearValue()
     */
    public function testGetClearValue()
    {
        // TODO Auto-generated CaptchaTest->testGetClearValue()
        $this->markTestIncomplete("getClearValue test not implemented");
        
        $this->Captcha->getClearValue(/* parameters */);
    }

    /**
     * Tests Captcha->getImagePath()
     */
    public function testGetImagePath()
    {
        // TODO Auto-generated CaptchaTest->testGetImagePath()
        $this->markTestIncomplete("getImagePath test not implemented");
        
        $this->Captcha->getImagePath(/* parameters */);
    }

    /**
     * Tests Captcha->check()
     */
    public function testCheck()
    {
        // TODO Auto-generated CaptchaTest->testCheck()
        $this->markTestIncomplete("check test not implemented");
        
        $this->Captcha->check(/* parameters */);
    }

    /**
     * Tests Captcha->destroy()
     */
    public function testDestroy()
    {
        // TODO Auto-generated CaptchaTest->testDestroy()
        $this->markTestIncomplete("destroy test not implemented");
        
        $this->Captcha->destroy(/* parameters */);
    }

    /**
     * Tests Captcha->__destruct()
     */
    public function test__destruct()
    {
        // TODO Auto-generated CaptchaTest->test__destruct()
        $this->markTestIncomplete("__destruct test not implemented");
        
        $this->Captcha->__destruct(/* parameters */);
    }
}

