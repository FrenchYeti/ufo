<?php
require_once 'UFO/Error/CorruptedDataException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * CorruptedDataException test case.
 */
class CorruptedDataExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var CorruptedDataException
     */
    private $CorruptedDataException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated CorruptedDataExceptionTest::setUp()
        
        $this->CorruptedDataException = new CorruptedDataException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated CorruptedDataExceptionTest::tearDown()
        $this->CorruptedDataException = null;
        
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

