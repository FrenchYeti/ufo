<?php
require_once '../UFO/Util/UnitReflection.php';

require_once 'PHPUnit/Framework/TestCase.php';

use Ufo\Util\UnitReflection as UnitReflection ;

class Car
{
    private $serial = null;

    protected $couleur = null;
    
    public $prix = null;
}

/**
 * UnitReflection test case.
 */
class Unit_ReflectionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var UnitReflection
     */
    private $UnitReflection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated UnitReflectionTest::setUp()
        
        $this->UnitReflection = new UnitReflection('Car');
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UnitReflectionTest::tearDown()
        $this->UnitReflection = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {}

    /**
     * Tests UnitReflection->__construct()
     */
    public function testConstruct()
    {
        $o = new UnitReflection('Car');
        
        $this->assertInstanceOf('UnitReflection',$o);
        $this->assertObjectHasAttribute('classRefelection',$o);
        
    }

    /**
     * Tests UnitReflection::getPropertyValue()
     * 
     * @depends testConstruct
     */
    public function testGetPropertyValue()
    {
        // TODO Auto-generated UnitReflectionTest::testGetPropertyValue()
        $this->markTestIncomplete("getPropertyValue test not implemented");
        
        UnitReflection::getPropertyValue(/* parameters */);
    }

    /**
     * Tests UnitReflection::setPropertyValue()
     */
    public function testSetPropertyValue()
    {
        // TODO Auto-generated UnitReflectionTest::testSetPropertyValue()
        $this->markTestIncomplete("setPropertyValue test not implemented");
        
        UnitReflection::setPropertyValue(/* parameters */);
    }
}

