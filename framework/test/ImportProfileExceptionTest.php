<?php
require_once 'tests/Session/Exception/ImportProfileException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * ImportProfileException test case.
 */
class ImportProfileExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ImportProfileException
     */
    private $ImportProfileException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated ImportProfileExceptionTest::setUp()
        
        $this->ImportProfileException = new ImportProfileException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ImportProfileExceptionTest::tearDown()
        $this->ImportProfileException = null;
        
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

