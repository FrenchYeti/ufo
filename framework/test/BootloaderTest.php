<?php
require_once 'UFO/Bootloader.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Bootloader test case.
 */
class BootloaderTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Bootloader
     */
    private $Bootloader;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated BootloaderTest::setUp()
        
        $this->Bootloader = new Bootloader(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated BootloaderTest::tearDown()
        $this->Bootloader = null;
        
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
     * Tests Bootloader::autoloader()
     */
    public function testAutoloader()
    {
        // TODO Auto-generated BootloaderTest::testAutoloader()
        $this->markTestIncomplete("autoloader test not implemented");
        
        Bootloader::autoloader(/* parameters */);
    }

    /**
     * Tests Bootloader::init()
     */
    public function testInit()
    {
        // TODO Auto-generated BootloaderTest::testInit()
        $this->markTestIncomplete("init test not implemented");
        
        Bootloader::init(/* parameters */);
    }

    /**
     * Tests Bootloader::initFront()
     */
    public function testInitFront()
    {
        // TODO Auto-generated BootloaderTest::testInitFront()
        $this->markTestIncomplete("initFront test not implemented");
        
        Bootloader::initFront(/* parameters */);
    }
}

