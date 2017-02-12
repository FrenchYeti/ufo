<?php
require_once 'tests/User/UserProxy.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * UserProxy test case.
 */
class UserProxyTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var UserProxy
     */
    private $UserProxy;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated UserProxyTest::setUp()
        
        $this->UserProxy = new UserProxy(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UserProxyTest::tearDown()
        $this->UserProxy = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
    }
}

