<?php

namespace Ufo\Error;

use Ufo\Log\Trace;

class UnsetException extends \Exception
{
	public function __construct($classname_str, $property, $file, $line, $code = 0, \Exception $previous = null)
	{
		Trace::add(_UFO_LOG_LOGICAL_,'['.$classname_str.'] UnsetException : Property "'.$property.'" cannot unset, in file :'.$file.' at line :'.$line);
		
		parent::__construct($classname_str.':'.$property.':'.$file.':'.$line, $code, $previous);
	}
}


