<?php

namespace Ufo\Controller;

use Ufo\HTTP\HttpRequest;
use Ufo\HTTP\TaintedString;
use Ufo\HTTP\DownloadManager;





class InvalidWildcardException extends \Exception{}
class InvalidRouteException extends \Exception{}
class ControllerNotFoundException extends \Exception{}
class InappropriateControllerException extends \Exception{} 
class FrontController
{
	public static $Routes;
	public static $StaticPrefix="file";

	/**
	 * Return a list of classes found in a file
	 * @param string $file
	 * @return array classname
	 */
	protected function GetClasses($file)
	{

		$php_code = file_get_contents ( $file );
		$classes = array ();
		$namespace="";
		$tokens = token_get_all ( $php_code );
		$count = count ( $tokens );

		for($i = 0; $i < $count; $i ++)
		{
			if ($tokens[$i][0]===T_NAMESPACE)
			{
				for ($j=$i+1;$j<$count;++$j)
				{
					if ($tokens[$j][0]===T_STRING)
						$namespace.="\\".$tokens[$j][1];
					elseif ($tokens[$j]==='{' or $tokens[$j]===';')
					break;
				}
			}
			if ($tokens[$i][0]===T_CLASS)
			{
				for ($j=$i+1;$j<$count;++$j)
				if ($tokens[$j]==='{')
				{
					$classes[]=$namespace."\\".$tokens[$i+2][1];
				}
			}
		}
		return $classes;
		//is_subclass_of(class, parent_class,/* allow first param to be string */true)
	}
	/**
	 * Starts handling the application
	 * Uses HttpRequest::InternalPath as input
	 */
	public function Start()
	{
		$Request=HttpRequest::InternalPath();
		if (substr($Request,0,strlen(self::$StaticPrefix)+1)==self::$StaticPrefix."/") //static requset
		{
			return $this->StaticContent(substr($Request,strlen(self::$StaticPrefix)+1));
		}
		else
		{			
			$file=$this->MatchRoutes($Request);
			return $this->StartController($file);
		}
	}

	protected function StaticContent($Request)
	{
		if (!$path=realpath(__DIR__."/../static/{$Request}")) return false;
		$root=realpath(__DIR__."/../static");
		if (substr($path,0,strlen($root))!==$root) return false; //LFD attack
		return DownloadManager::download($path,$path);
	}

	/**
	 * Finds the appropriate route among routes array,
	 * and returns the filename
	 * @param string $Request
	 * @throws InvalidWildcardException
	 * @throws InvalidRouteException
	 * @return string filename
	 */
	protected function MatchRoutes($Request)
	{
		$file=null;
		foreach (self::$Routes as $route=>$controller)
		{
			if (strpos($route,"*")!==false) //wildcard route
			{
				if (strpos($route,"*")!=strlen($route)-1)
					throw new InvalidWildcardException("You can only set wildcard as last character of a route: {$route}");
				if (substr($Request,0,strlen($route)-1 )==substr($route,0,-1))
				{
					$file=$controller;
					$this->restOfRequest=substr($Request,strlen($route)-1);
				}
			}
			else
			{
				if ($Request==$route)
					$file=$controller;
			}
			if (!$file) continue; //route not found
			
			if( file_exists(_UFO_LOCAL_CONTROLLERS_DIR_."{$file}.php")){
				$originalFile=_UFO_LOCAL_CONTROLLERS_DIR_."{$file}.php";
				$file=realpath($originalFile);
				if (!$file) //file not found
					throw new InvalidRouteException("Route '{$route}' points to a non-existing file '{$originalFile}'");
			}
			else{
				$originalFile=_UFO_GLOBAL_CONTROLLERS_DIR_."{$file}.php";
				$file=realpath($originalFile);
				if (!$file) //file not found
					throw new InvalidRouteException("Route '{$route}' points to a non-existing file '{$originalFile}'");
			}
			
				
			//everything set, return this file
			break;
		}
		if (!$file) return ""; //no route found
		return $file;
	}
	/**
	 * Starts a controller
	 * by finding classes inside the file, instantiating the first matching one,
	 * and calling its start method.
	 * @param string $file
	 * @throws ControllerNotFoundException
	 * @throws InappropriateControllerException
	 */
	protected function StartController($file)
	{
		//get list of classes inside the controller file
		$classes=$this->GetClasses($file);
		if (count($classes)==0)
			throw new ControllerNotFoundException("No controller found inside {$file}");

		//check for the first instance of framework controller
		require_once $file;
		
		$name_defaultcontroller = __NAMESPACE__."\\DefaultController";
		$name_controller = __NAMESPACE__."\\Controller";
		
		$index=-1;
		foreach ($classes as $k=>$class)
		{
		    $name_controller = __NAMESPACE__."\\Controller";
			if( is_subclass_of($class, $name_controller))
			{
				$index=$k;
				break; //match the first one
			}
		}
		
		if ($index==-1) //appropriate controller not found
			throw new InappropriateControllerException("The controller in {$file} should be a subclass of Ufo\Controller\Controller");
		
		$class=$classes[$index];

		if ( is_subclass_of($class,$name_defaultcontroller)) //default controller instance
		{
		    if( !isset($this->restOfRequest))
		        $rest = HttpRequest::InternalPath();
		    else 
		        $rest = $this->restOfRequest;
		    
			$rc=new \ReflectionClass($class);
			$controllerObject=$rc->newInstanceArgs(array($rest));
		}
		else //normal controller
		{
			$controllerObject=new $class;
		}
		return $controllerObject->Start();
	}


	function NotFound()
	{
		$file=_UFO_ROOT_DIR_."/view/404.php";
		if (realpath($file))
			require $file;
	}
}




?>