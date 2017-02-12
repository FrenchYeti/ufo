<?php

namespace Ufo;

use Ufo\HTTP\HttpRequest;
use Ufo\HTTP\TaintedString;
use Ufo\Error\ErrorHandler;
use Ufo\User\UserManagerException;
use Ufo\User\UserManagerOpenException;
use Ufo\User\UserManagerSessionNotFound;
	
	
class AutoloadException extends \Exception {}
 
/** 
 * @author gb-michel
 * 
 */
class Bootloader
{
	static public $_internals = array();
	
	static public $isInitialized = false;
    
    /**
     * @var unknown
     */
    static private $_overclass = array(
    		'Invoker'=>'Invoker.php',
    		'Captcha'=>'Captcha/Captcha.php',
    		'Form'=>'Form/Form.php',
    		'User'=>'User/User.php',
    		'Util'=>'Util/Util.php',
    	    'UserManager'=>'User/UserManager.php',	
        
    		'Core/ObjectProxy'=>'ObjectManager.php',
    		'Core/ObjectManagerInterface'=>'ObjectManager.php',
    		
            'Controller/Controller'=>'Controller/DefaultController.php',
    		'Controller/InvalidWildcardException'=>'Controller/FrontController.php',
    		'Controller/InvalidRouteException'=>'Controller/FrontController.php',
    		'Controller/ControllerNotFoundException'=>'Controller/FrontController.php',
    		'Controller/InappropriateControllerException'=>'Controller/FrontController.php',
    		
    		'Db/DatabaseNotSetException'=>'Db/Connexion.php',
            'Db/ManagerException'=>'Db/Manager.php',
            'Db/ConnexionException'=>'Db/Connexion.php',
            'Db/ProfileException'=>'Db/Profile.php',
    		
    		'Error/ErrorHandlerAlreadySetException'=>'Error/ErrorHandler.php',
    		'Error/ErrorHandlerNotSetException'=>'Error/ErrorHandler.php',
    		
    		'HTTP/InvalidFileModifiedDateExeption'=>'HTTP/DownloadManager.php',
    		'HTTP/HttpRequestArray'=>'HTTP/HttpRequest.php',
    		'HTTP/HttpRequestException'=>'HTTP/HttpRequest.php',
    		'HTTP/HttpRequestInsecureParameterException'=>'HTTP/HttpRequest.php',
    		'HTTP/BaseURLNotSetException'=>'HTTP/HttpRequest.php',
    		'HTTP/ModifiedInputsException'=>'HTTP/Inputs.php',
    		'HTTP/TaintedSanitizerErrorException'=>'HTTP/Tainted.php',
    		
    		'Log/MediaNotSupported'=>'Log/Logger.php',
    		'Log/UnsupportedConfigFile'=>'Log/Logger.php',
    		'Log/Workers/MailException'=>'Log/Workers/MAIL.php',
    		'Log/Workers/MailNotSendException'=>'Log/Workers/MAIL.php',
    		
    		'RBAC/AuthorizationException'=>'RBAC/Authorization.php',
    		'RBAC/OperationException'=>'RBAC/Operation.php',
    		'RBAC/InvalidFieldOperationException'=>'RBAC/Operation.php',
    		'RBAC/OperationCategorieException'=>'RBAC/OperationCategorie.php',
    		'RBAC/InvalidFieldOperationCategorieException'=>'RBAC/OperationCategorie.php',
    		'RBAC/InvalidFieldRoleException'=>'RBAC/Role.php',
    		'RBAC/RoleException'=>'RBAC/Role.php',
    		'RBAC/RoleNotExistsException'=>'RBAC/Role.php',
    		
    		'Security/BruteForceAttackDetectedException'=>'AdvancedPasswordManagement.php',
    		
    		'Session'=>'Session/Session.php',
    		'Session/SessionListener'=>'Session/Session.php',
    		'Session/SessionException'=>'Session/Session.php',
    		'Session/SessionExpired'=>'Session/Session.php',
    		'Session/SessionNotFoundException'=>'Session/Session.php',
    		'Session/NullUserException'=>'Session/Session.php',
    		'Session/DataIntegrityException'=>'Session/Session.php',
    		'Session/DataNotExistsException'=>'Session/Session.php',
    		'Session/SessionManagerException'=>'Session/SessionManager.php',
    		'Session/SessionManagerNotImported'=>'Session/SessionManager.php',
    		'Session/SessionSupportNotFound'=>'Session/SessionManager.php',
    		'Session/SessionManagerNotStoredException'=>'Session/SessionManager.php',
    		'Session/SessionNotManaged'=>'Session/SessionManager.php',
    		'Session/InvalidSessionNameException'=>'Session/SessionManager.php',
    		
    		'User/UserAccountInactive'=>'User/User.php',
    		'User/UserExistsInactive'=>'User/User.php',
    		'User/UserException'=>'User/User.php',
    		'User/UserIDInvalid'=>'User/User.php',
    		'User/UserLocked'=>'User/User.php',
    		'User/UserNotExistsException'=>'User/User.php',
    		'User/UserExistsException'=>'User/User.php',
    		'User/UserRoleNotExistsException'=>'User/User.php',
    		'User/WrongPasswordException'=>'User/User.php',
    		'User/UserManagerException'=>'User/UserManager.php',
    		'User/UserManagerOpenException'=>'User/UserManager.php',
    		'User/UserManagerSessionNotFound'=>'User/UserManager.php',
    		
    		'InconcistentDbEntityTemplateCommandException'=>'Entity/Db/Check/TemplateCommand.php',
    		'AutoloadException'=>'Bootloader.php'
    );
    
    /**
     * 
     * @param unknown $classname_str
     * @throws AutoloadException
     * @return boolean
     */
	static public function autoloader( $classname_str)
	{
	    $tmp_class = explode('\\', $classname_str);
		$ns1 = array_shift($tmp_class);
		
		// If UFO is namespace
		if( $ns1 == 'Ufo'){
					    
			$rel_clsname = str_replace( 'Ufo', __DIR__, $classname_str);
			$cls_file = str_replace('\\','/',$rel_clsname.'.php');
			
			if( file_exists($cls_file)){
				require_once $cls_file;
				return true;
			}
			else{

                // remove first char if is a / or a \
			    if(($classname_str[0] == '/')||($classname_str[0] == '\\')){
			        $ufo_clsname = substr($classname_str,1);
			    }
			    else{
			        $ufo_clsname = $classname_str;
			    }
			    
			    // remove Ufo from name
			    $ufo_clsname = substr($ufo_clsname,4);
			    $ufo_clsname = str_replace('\\','/',$ufo_clsname);
			    
				if( isset(self::$_overclass[$ufo_clsname])){
					require_once __DIR__.'/'.self::$_overclass[$ufo_clsname];
					return true;
				}
				else{
					throw new AutoloadException("ERROR: Class load fail, unknow file");
					return false;
				}	
			}
		}
		elseif( $ns1 == _UFO_APP_NAMESPACE_){
			
			$cls_file = str_replace( _UFO_APP_NAMESPACE_, _UFO_APP_INCLUDE_PATH_, $classname_str);
			$cls_file = str_replace('\\','/',$cls_file.'.php');
            
			if( file_exists($cls_file)){
				require_once $cls_file;				
				return true;
			}
			elseif( isset(self::$_overclass[$classname_str])){
				require_once __DIR__.self::$_overclass[$classname_str];
				return true;
			}
			else{
				throw new AutoloadException("ERROR: Class load fail, unknow file");
				return false;
			}
		}
		/* else{
		     throw new AutoloadException("ERROR: Class load fail, namespace unknow");
		     return false;
		} */
	}
	
    /**
     * 
     * @param unknown $configpath_str
     * @param string $errorfuncpath_str
     */
    static public function init($configpath_str,$errorfuncpath_str = null,$overwriteCOOKIE = true)
    {
        if( self::$isInitialized == true) return ;
        
        // include error handler function
        // default load error\handler class from UFO
        if(!is_null($errorfuncpath_str)){
            require_once($errorfuncpath_str);
        }
        
        // include config file
        require_once($configpath_str);
        require_once(__DIR__.'/Core/load.php');
        
        // prepare internals
        self::$_internals = explode(':', _UFO_INTERNALS_DB_PROFILE_);
        
        date_default_timezone_set('UTC');
        
        // add autoload
        $o = new Bootloader();
        spl_autoload_register( array($o,'autoloader'));
		
        if(is_null($errorfuncpath_str)){
       
            if( _UFO_ERROR_HANDLER_ === null){
                Error\ErrorHandler::enable();
            }
            else{
                $eh = new Error\ErrorHandler();
                set_error_handler( array( $eh,_UFO_ERROR_HANDLER_));
            }            
        }
        else{            
            set_error_handler( basename($errorfuncpath_str,'.php').'::'._UFO_ERROR_HANDLER_);
        }

        // Gestion du jeux de caractere interne pour MbString
        mb_internal_encoding( 'UTF-8');

        // overwrite SESSION handlers with logger
        // session_set_save_handler();
        
        // Sanitize global var
        HTTP\Inputs::init($overwriteCOOKIE);
        
        self::$isInitialized = true;
    }
    
    
    /**
     * Initialize front controller
     */
    static public function initFront()
    {       
    	require_once _UFO_ROUTES_CONFIG_;
    	
    	if ( HttpRequest::isCLI()) 	//php-cli
    	{
    	    // the request should be provided in CLI as:
    	    // hp front.php "folder/file?a=b&cd="
    	    if ($argc == 1)
    	        HttpRequest::SetBaseURL ( "http://localhost/" );
    	    else {
    	        HttpRequest::SetBaseURL ( "http://localhost/" . $argv [1] );
    	        if (strpos ( $argv [1], "?" ) !== false) 		// query string extraction
    	        {
    	            $QueryString = substr ( $argv [1], strpos ( $argv [1], "?" ) + 1 );
    	            $Params = explode ( "&", $QueryString );
    	            foreach ( $Params as $p ) {
    	                if (strpos ( $p, "=" ) === false) {
    	                    $tainted = new TaintedString("");
    	                    $tainted->decontaminate();
    	                    $_GET [urldecode ( $p )] = $tainted;
    	                    continue;
    	                }
    	                list ( $k, $v ) = explode ( "=", $p );
    	                $_GET [urldecode ( $k )] = new TaintedString(urldecode ( $v ));
    	            }
    	        }
    	    }
    	} 
    	else 
    	{
    	    if( $_GET['___r']->isAutogenerated()){
    	        $InternalRequest = '';
    	    }
    	    else{
    	        $InternalRequest = $_GET['___r']->setDefault('')->sanitizeWithCheck('specificPureText','-_%=?#&./',true,false,200);
    	    }
    	   
    	    unset ( $_GET ['___r'] );
    	    unset ( $_REQUEST ['___r'] );
    	    
    	    
    	    $URL = HttpRequest::URL ( false );
    	    HttpRequest::SetBaseURL ( substr ( $URL, 0, strlen ( $URL ) - strlen ( $InternalRequest ) ) );
    	}
    	
    	$FrontController=new Controller\FrontController();

    	if (!$FrontController->Start())
    		$FrontController->NotFound();
    }
    
    static public function initInvok()
    {
        try{
            $invoker = new Invoker();
            $invoker->invoke();
        }
        catch( \Exception $e){
            echo $e->getMessage().'<br>'.$e->getTraceAsString();
        }
    }
}


?>