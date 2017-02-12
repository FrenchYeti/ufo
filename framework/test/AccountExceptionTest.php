<?php
require_once 'tests/User/Exception/AccountException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * AccountException test case.
 */
class AccountExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var AccountException
     */
    private $AccountException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated AccountExceptionTest::setUp()
        
        $this->AccountException = new AccountException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AccountExceptionTest::tearDown()
        $this->AccountException = null;
        
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
     * Tests AccountException->__construct()
     */
    public function test__construct()
    {
        // TODO Auto-generated AccountExceptionTest->test__construct()
        $this->markTestIncomplete("__construct test not implemented");
        
        $this->AccountException->__construct(/* parameters */);
    }

    /**
     * Tests AccountException->__toString()
     */
    public function test__toString()
    {
        // TODO Auto-generated AccountExceptionTest->test__toString()
        $this->markTestIncomplete("__toString test not implemented");
        
        $this->AccountException->__toString(/* parameters */);
    }
}

