<?php
require_once 'tests/HTTP/Exception/DownloadManagerException.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * DownloadManagerException test case.
 */
class DownloadManagerExceptionTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var DownloadManagerException
     */
    private $DownloadManagerException;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated DownloadManagerExceptionTest::setUp()
        
        $this->DownloadManagerException = new DownloadManagerException(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated DownloadManagerExceptionTest::tearDown()
        $this->DownloadManagerException = null;
        
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

