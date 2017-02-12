<?php

namespace Ufo\Error;

use Ufo\Log\Trace;

class MutatorException extends \Exception
{
	public function __construct($classname_str, $property, $file, $line, $code = 0, \Exception $previous = null)
	{
		Trace::add(_UFO_LOG_LOGICAL_,'['.$classname_str.'] MutatorException : Property "'.$property.'" not exists, in file :'.$file.' at line :'.$line);
		
		parent::__construct($classname_str.':'.$property.':'.$file.':'.$line, $code, $previous);
	}
}


