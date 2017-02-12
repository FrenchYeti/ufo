<?php
require_once 'tests/HTTP/DownloadManager.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * DownloadManager test case.
 */
class DownloadManagerTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var DownloadManager
     */
    private $DownloadManager;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated DownloadManagerTest::setUp()
        
        $this->DownloadManager = new DownloadManager(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated DownloadManagerTest::tearDown()
        $this->DownloadManager = null;
        
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
     * Tests DownloadManager::MIME()
     */
    public function testMIME()
    {
        // TODO Auto-generated DownloadManagerTest::testMIME()
        $this->markTestIncomplete("MIME test not implemented");
        
        DownloadManager::MIME(/* parameters */);
    }

    /**
     * Tests DownloadManager::download()
     */
    public function testDownload()
    {
        // TODO Auto-generated DownloadManagerTest::testDownload()
        $this->markTestIncomplete("download test not implemented");
        
        DownloadManager::download(/* parameters */);
    }

    /**
     * Tests DownloadManager::serveData()
     */
    public function testServeData()
    {
        // TODO Auto-generated DownloadManagerTest::testServeData()
        $this->markTestIncomplete("serveData test not implemented");
        
        DownloadManager::serveData(/* parameters */);
    }
}

