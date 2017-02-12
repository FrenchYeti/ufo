<?php
require_once 'tests/HTTP/HttpRequest.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * HttpRequest test case.
 */
class HttpRequestTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var HttpRequest
     */
    private $HttpRequest;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated HttpRequestTest::setUp()
        
        $this->HttpRequest = new HttpRequest(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated HttpRequestTest::tearDown()
        $this->HttpRequest = null;
        
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
     * Tests HttpRequest::SetBaseURL()
     */
    public function testSetBaseURL()
    {
        // TODO Auto-generated HttpRequestTest::testSetBaseURL()
        $this->markTestIncomplete("SetBaseURL test not implemented");
        
        HttpRequest::SetBaseURL(/* parameters */);
    }

    /**
     * Tests HttpRequest::isCLI()
     */
    public function testIsCLI()
    {
        // TODO Auto-generated HttpRequestTest::testIsCLI()
        $this->markTestIncomplete("isCLI test not implemented");
        
        HttpRequest::isCLI(/* parameters */);
    }

    /**
     * Tests HttpRequest::IP()
     */
    public function testIP()
    {
        // TODO Auto-generated HttpRequestTest::testIP()
        $this->markTestIncomplete("IP test not implemented");
        
        HttpRequest::IP(/* parameters */);
    }

    /**
     * Tests HttpRequest::URL()
     */
    public function testURL()
    {
        // TODO Auto-generated HttpRequestTest::testURL()
        $this->markTestIncomplete("URL test not implemented");
        
        HttpRequest::URL(/* parameters */);
    }

    /**
     * Tests HttpRequest::Host()
     */
    public function testHost()
    {
        // TODO Auto-generated HttpRequestTest::testHost()
        $this->markTestIncomplete("Host test not implemented");
        
        HttpRequest::Host(/* parameters */);
    }

    /**
     * Tests HttpRequest::ServerName()
     */
    public function testServerName()
    {
        // TODO Auto-generated HttpRequestTest::testServerName()
        $this->markTestIncomplete("ServerName test not implemented");
        
        HttpRequest::ServerName(/* parameters */);
    }

    /**
     * Tests HttpRequest::Protocol()
     */
    public function testProtocol()
    {
        // TODO Auto-generated HttpRequestTest::testProtocol()
        $this->markTestIncomplete("Protocol test not implemented");
        
        HttpRequest::Protocol(/* parameters */);
    }

    /**
     * Tests HttpRequest::isHTTPS()
     */
    public function testIsHTTPS()
    {
        // TODO Auto-generated HttpRequestTest::testIsHTTPS()
        $this->markTestIncomplete("isHTTPS test not implemented");
        
        HttpRequest::isHTTPS(/* parameters */);
    }

    /**
     * Tests HttpRequest::isHTTP()
     */
    public function testIsHTTP()
    {
        // TODO Auto-generated HttpRequestTest::testIsHTTP()
        $this->markTestIncomplete("isHTTP test not implemented");
        
        HttpRequest::isHTTP(/* parameters */);
    }

    /**
     * Tests HttpRequest::ChangeProtocol()
     */
    public function testChangeProtocol()
    {
        // TODO Auto-generated HttpRequestTest::testChangeProtocol()
        $this->markTestIncomplete("ChangeProtocol test not implemented");
        
        HttpRequest::ChangeProtocol(/* parameters */);
    }

    /**
     * Tests HttpRequest::Port()
     */
    public function testPort()
    {
        // TODO Auto-generated HttpRequestTest::testPort()
        $this->markTestIncomplete("Port test not implemented");
        
        HttpRequest::Port(/* parameters */);
    }

    /**
     * Tests HttpRequest::PortReadable()
     */
    public function testPortReadable()
    {
        // TODO Auto-generated HttpRequestTest::testPortReadable()
        $this->markTestIncomplete("PortReadable test not implemented");
        
        HttpRequest::PortReadable(/* parameters */);
    }

    /**
     * Tests HttpRequest::RequestURI()
     */
    public function testRequestURI()
    {
        // TODO Auto-generated HttpRequestTest::testRequestURI()
        $this->markTestIncomplete("RequestURI test not implemented");
        
        HttpRequest::RequestURI(/* parameters */);
    }

    /**
     * Tests HttpRequest::InternalRequestURI()
     */
    public function testInternalRequestURI()
    {
        // TODO Auto-generated HttpRequestTest::testInternalRequestURI()
        $this->markTestIncomplete("InternalRequestURI test not implemented");
        
        HttpRequest::InternalRequestURI(/* parameters */);
    }

    /**
     * Tests HttpRequest::QueryString()
     */
    public function testQueryString()
    {
        // TODO Auto-generated HttpRequestTest::testQueryString()
        $this->markTestIncomplete("QueryString test not implemented");
        
        HttpRequest::QueryString(/* parameters */);
    }

    /**
     * Tests HttpRequest::Method()
     */
    public function testMethod()
    {
        // TODO Auto-generated HttpRequestTest::testMethod()
        $this->markTestIncomplete("Method test not implemented");
        
        HttpRequest::Method(/* parameters */);
    }

    /**
     * Tests HttpRequest::Path()
     */
    public function testPath()
    {
        // TODO Auto-generated HttpRequestTest::testPath()
        $this->markTestIncomplete("Path test not implemented");
        
        HttpRequest::Path(/* parameters */);
    }

    /**
     * Tests HttpRequest::InternalPath()
     */
    public function testInternalPath()
    {
        // TODO Auto-generated HttpRequestTest::testInternalPath()
        $this->markTestIncomplete("InternalPath test not implemented");
        
        HttpRequest::InternalPath(/* parameters */);
    }

    /**
     * Tests HttpRequest::Root()
     */
    public function testRoot()
    {
        // TODO Auto-generated HttpRequestTest::testRoot()
        $this->markTestIncomplete("Root test not implemented");
        
        HttpRequest::Root(/* parameters */);
    }

    /**
     * Tests HttpRequest::ServerIP()
     */
    public function testServerIP()
    {
        // TODO Auto-generated HttpRequestTest::testServerIP()
        $this->markTestIncomplete("ServerIP test not implemented");
        
        HttpRequest::ServerIP(/* parameters */);
    }
}

