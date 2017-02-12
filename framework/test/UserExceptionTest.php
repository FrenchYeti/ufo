<?php
require_once 'tests/User/Exception/UserException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * UserException test case.
 */
class UserExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var UserException
     */
    private $UserException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated UserExceptionTest::setUp()
        
        $this->UserException = new UserException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated UserExceptionTest::tearDown()
        $this->UserException = null;
        
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

