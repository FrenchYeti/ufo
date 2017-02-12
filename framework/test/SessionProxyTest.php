<?php
require_once 'tests/Session/SessionProxy.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * SessionProxy test case.
 */
class SessionProxyTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var SessionProxy
     */
    private $SessionProxy;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated SessionProxyTest::setUp()
        
        $this->SessionProxy = new SessionProxy(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated SessionProxyTest::tearDown()
        $this->SessionProxy = null;
        
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

