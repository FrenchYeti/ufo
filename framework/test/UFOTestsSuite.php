<?php
require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'tests/Error/AccessorExceptionTest.php';

require_once 'tests/User/Exception/AccountExceptionTest.php';

require_once 'testu/AdvancedPasswordManagementTest.php';

require_once 'tests/RBAC/AuthorizationTest.php';

require_once 'tests/Security/BasicPasswordManagementTest.php';

require_once 'tests/BootloaderTest.php';

require_once 'testu/CallExceptionTest.php';

require_once 'tests/Captcha/CaptchaTest.php';

require_once 'tests/Security/CheckTest.php';

require_once 'tests/Error/CollectionExceptionTest.php';

require_once 'testu/ColumnLinkTest.php';

require_once 'tests/Db/ConnexionTest.php';

require_once 'testu/CorruptedDataExceptionTest.php';

require_once 'testu/DbExceptionTest.php';

require_once 'testu/DBLogsTest.php';

require_once 'tests/Directory/DirectoryGroupTest.php';

require_once 'tests/Directory/DirectoryRoleTest.php';

require_once 'tests/Directory/DirectoryTest.php';

require_once 'testu/DownloadManagerExceptionTest.php';

require_once 'testu/DownloadManagerTest.php';

require_once 'testu/EmptyValueExceptionTest.php';

require_once 'tests/Crypto/EncryptionTest.php';

require_once 'tests/Entity/Db/EntityCollectionTest.php';

require_once 'tests/Entity/Db/Exception/EntityExceptionTest.php';

require_once 'testu/ErrorHandlerTest.php';

require_once 'testu/FILETest.php';

require_once 'tests/Entity/Db/Link/ForeignLinkTest.php';

require_once 'tests/Form/FormTest.php';

require_once 'testu/FrontControllerTest.php';

require_once 'tests/HTTP/HttpRequestTest.php';

require_once 'tests/Session/Exception/ImportProfileExceptionTest.php';

require_once 'testu/InputsTest.php';

require_once 'testu/IssetExceptionTest.php';

require_once 'tests/Log/LoggerTest.php';

require_once 'testu/MAILTest.php';

require_once 'tests/Db/ManagerTest.php';

require_once 'tests/Error/MutatorExceptionTest.php';

require_once 'tests/RBAC/OperationCategorieTest.php';

require_once 'testu/OperationTest.php';

require_once 'PHPUnit/Extensions/Database/TestCase.php';

require_once 'PHPUnit/Extensions/GroupTestSuite.php';

require_once 'PHPUnit/Extensions/OutputTestCase.php';

require_once 'PHPUnit/Extensions/PhptTestSuite.php';

require_once 'PHPUnit/Framework/TestSuite/DataProvider.php';

require_once 'PHPUnit/Framework/Warning.php';

require_once 'testu/ProfileSessionTest.php';

require_once 'tests/Db/ProfileTest.php';

require_once 'testu/RegisterTest.php';

require_once 'testu/RingExceptionTest.php';

require_once 'testu/RingTest.php';

require_once 'tests/RBAC/RoleTest.php';

require_once 'tests/Captcha/Exception/RuntimeExceptionTest.php';

require_once 'testu/SanitizerTest.php';

require_once 'tests/Session/SessionManagerTest.php';

require_once 'testu/SessionProxyTest.php';

require_once 'tests/Session/SessionTest.php';

require_once 'testu/StackTest.php';

require_once 'tests/Error/StandardExceptionTest.php';

require_once 'tests/Db/StatementTest.php';

require_once 'tests/Log/Workers/SYSLOGTest.php';

require_once 'tests/Entity/Db/Link/TableLinkTest.php';

require_once 'tests/HTTP/TaintedArrayTest.php';

require_once 'tests/HTTP/TaintedInputsTest.php';

require_once 'tests/HTTP/TaintedStringTest.php';

require_once 'testu/TaintedTest.php';

require_once 'testu/TemplateCommandTest.php';

require_once 'testu/TraceTest.php';

require_once 'tests/Util/UnitReflectionTest.php';

require_once 'testu/UnsetExceptionTest.php';

require_once 'tests/User/Exception/UserExceptionTest.php';

require_once 'testu/UserManagementTest.php';

require_once 'tests/User/UserManagerTest.php';

require_once 'tests/User/UserProxyTest.php';

require_once 'testu/UserTest.php';

require_once 'tests/Util/UtilTest.php';

require_once 'testu/XUserTest.php';

/**
 * Static test suite.
 */
class UFOTestsSuite extends PHPUnit_Framework_TestSuite
{

    /**
     * Constructs the test suite handler.
     */
    public function __construct()
    {
        $this->setName('UFOTestsSuite');
        
        $this->addTestSuite('AccessorExceptionTest');
        
        $this->addTestSuite('AccountExceptionTest');
        
        $this->addTestSuite('AdvancedPasswordManagementTest');
        
        $this->addTestSuite('AuthorizationTest');
        
        $this->addTestSuite('BasicPasswordManagementTest');
        
        $this->addTestSuite('BootloaderTest');
        
        $this->addTestSuite('CallExceptionTest');
        
        $this->addTestSuite('CaptchaTest');
        
        $this->addTestSuite('CheckTest');
        
        $this->addTestSuite('CollectionExceptionTest');
        
        $this->addTestSuite('ColumnLinkTest');
        
        $this->addTestSuite('ConnexionTest');
        
        $this->addTestSuite('CorruptedDataExceptionTest');
        
        $this->addTestSuite('DbExceptionTest');
        
        $this->addTestSuite('DBLogsTest');
        
        $this->addTestSuite('DirectoryGroupTest');
        
        $this->addTestSuite('DirectoryRoleTest');
        
        $this->addTestSuite('DirectoryTest');
        
        $this->addTestSuite('DownloadManagerExceptionTest');
        
        $this->addTestSuite('DownloadManagerTest');
        
        $this->addTestSuite('EmptyValueExceptionTest');
        
        $this->addTestSuite('EncryptionTest');
        
        $this->addTestSuite('EntityCollectionTest');
        
        $this->addTestSuite('EntityExceptionTest');
        
        $this->addTestSuite('ErrorHandlerTest');
        
        $this->addTestSuite('FILETest');
        
        $this->addTestSuite('ForeignLinkTest');
        
        $this->addTestSuite('FormTest');
        
        $this->addTestSuite('FrontControllerTest');
        
        $this->addTestSuite('HttpRequestTest');
        
        $this->addTestSuite('ImportProfileExceptionTest');
        
        $this->addTestSuite('InputsTest');
        
        $this->addTestSuite('IssetExceptionTest');
        
        $this->addTestSuite('LoggerTest');
        
        $this->addTestSuite('MAILTest');
        
        $this->addTestSuite('ManagerTest');
        
        $this->addTestSuite('MutatorExceptionTest');
        
        $this->addTestSuite('OperationCategorieTest');
        
        $this->addTestSuite('OperationTest');
        
        $this->addTestSuite('PHPUnit_Extensions_Database_TestCase');
        
        $this->addTestSuite('PHPUnit_Extensions_GroupTestSuite');
        
        $this->addTestSuite('PHPUnit_Extensions_OutputTestCase');
        
        $this->addTestSuite('PHPUnit_Extensions_PhptTestSuite');
        
        $this->addTestSuite('PHPUnit_Framework_TestSuite_DataProvider');
        
        $this->addTestSuite('PHPUnit_Framework_Warning');
        
        $this->addTestSuite('ProfileSessionTest');
        
        $this->addTestSuite('ProfileTest');
        
        $this->addTestSuite('RegisterTest');
        
        $this->addTestSuite('RingExceptionTest');
        
        $this->addTestSuite('RingTest');
        
        $this->addTestSuite('RoleTest');
        
        $this->addTestSuite('RuntimeExceptionTest');
        
        $this->addTestSuite('SanitizerTest');
        
        $this->addTestSuite('SessionManagerTest');
        
        $this->addTestSuite('SessionProxyTest');
        
        $this->addTestSuite('SessionTest');
        
        $this->addTestSuite('StackTest');
        
        $this->addTestSuite('StandardExceptionTest');
        
        $this->addTestSuite('StatementTest');
        
        $this->addTestSuite('SYSLOGTest');
        
        $this->addTestSuite('TableLinkTest');
        
        $this->addTestSuite('TaintedArrayTest');
        
        $this->addTestSuite('TaintedInputsTest');
        
        $this->addTestSuite('TaintedStringTest');
        
        $this->addTestSuite('TaintedTest');
        
        $this->addTestSuite('TemplateCommandTest');
        
        $this->addTestSuite('TraceTest');
        
        $this->addTestSuite('UnitReflectionTest');
        
        $this->addTestSuite('UnsetExceptionTest');
        
        $this->addTestSuite('UserExceptionTest');
        
        $this->addTestSuite('UserManagementTest');
        
        $this->addTestSuite('UserManagerTest');
        
        $this->addTestSuite('UserProxyTest');
        
        $this->addTestSuite('UserTest');
        
        $this->addTestSuite('UtilTest');
        
        $this->addTestSuite('XUserTest');
    }

    /**
     * Creates the suite.
     */
    public static function suite()
    {
        return new self();
    }
}

