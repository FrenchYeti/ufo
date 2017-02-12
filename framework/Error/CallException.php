<?php

namespace Ufo\Error;

use Ufo\Log\Trace;

class CallException extends \Exception
{
	public function __construct($classname_str, $method, $file, $line, $code = 0, \Exception $previous = null)
	{
		Trace::add(_UFO_LOG_LOGICAL_,'['.$classname_str.'] CallException : Method "'.$method.'" not exist, in file :'.$file.' at line :'.$line);
		
		parent::__construct($classname_str.':'.$method.':'.$file.':'.$line, $code, $previous);
	}
}


