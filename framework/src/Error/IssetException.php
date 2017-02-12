<?php

namespace Ufo\Error;

use Ufo\Log\Trace;

class IssetException extends \Exception
{
	public function __construct($classname_str, $ppt, $file, $line, $code = 0, \Exception $previous = null)
	{
		Trace::add(_UFO_LOG_LOGICAL_,'['.$classname_str.'] IssetException : Property "'.$ppt.'" not exist, in file :'.$file.' at line :'.$line);
		
		parent::__construct($classname_str.':'.$ppt.':'.$file.':'.$line, $code, $previous);
	}
}


