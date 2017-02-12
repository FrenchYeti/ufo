<?php
require_once '../UFO/Util/Util.php';

require_once 'PHPUnit/Framework/TestCase.php';

use Ufo\Util\Util as Util ;


class Car
{
    public $price = 0;
    public $color = null;
}

/**
 * Util test case.
 */
class Util_UtilTest extends PHPUnit_Framework_TestCase
{
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

    }

    /**
     * Tests Util::randomString()
     */
    public function testRandomString()
    {
        $this->assertInternalType('string',Util::randomString(32),'Returned value is not a string.');
        $this->assertEquals(32,strlen(Util::randomString(32)),'Returned value has not same length as passed in params');
        $this->assertEquals('',Util::randomString(0),'If size is 0, returned string must be empty.');
        $this->assertEquals(0,strlen(Util::randomString(0)),'If size is 0, returned string must be empty.');
    }
    
    /**
     * Tests Util::ArrayToObject()
     */
    public function testArrayToObject()
    {
        $o1 = new Car();
        $o1->color = 'yellow';
         
        $this->assertSame($o1,Util::ArrayToObject($o1,array('color'=>'red')),'If an instance is passed in params, return object must be the same instance.');
        $this->assertEquals('red',Util::ArrayToObject($o1,array('color'=>'red'))->color);
    
        unset($o2,$o1);
    }
    
    
    /**
     * Tests Util::ArrayToObject()
     * 
     */
    public function testNewIntanciationWithArrayToObject()
    {
        $o = Util::ArrayToObject('Car',array('color'=>'red','price'=>17000,'extra'=>'clim'));
         
        $this->assertInternalType('object',$o,'Returned value must be an object');
        $this->assertInstanceOf('Car',$o,'Returned value must be an instance of the classname passed in arguments');
        $this->assertObjectHasAttribute('color', $o);
        $this->assertObjectHasAttribute('price', $o);
        $this->assertObjectNotHasAttribute('extra', $o);
        $this->assertInternalType('int', $o->price);
        $this->assertInternalType('string', $o->color);
        $this->assertEquals('red',$o->color);
        $this->assertEquals(17000,$o->price);
         
        unset($o);
    }
    
    /**
     *  Tests Util::ArrayToObject()
     */
    public function testEmptyArrayWithArrayToObject()
	{
	    $o1 = new Car();
	    $o1->color = 'red';

	    $o2 = Util::ArrayToObject($o1,array());
	    
	    $this->assertInternalType('object',$o2);
	    $this->assertInstanceOf('Car',$o2);
	    $this->assertObjectHasAttribute('color', $o2);
	    $this->assertEquals('red',$o2->color);
	    
	    unset($o2,$o1);
	}

	/**
	 * Tests Util::make_UTF8_RegexpPatternFrom()
	 */
	public function testMake_UTF8_RegexpPatternFrom()
	{
	    $this->assertInternalType('string', Util::make_UTF8_RegexpPatternFrom('?,-'));
	    $this->assertEquals('\x{003f}\x{002c}\x{002d}', Util::make_UTF8_RegexpPatternFrom('?,-'));
	} 
}

