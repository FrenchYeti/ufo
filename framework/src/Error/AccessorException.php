<?php

namespace Ufo\Error;

use Ufo\Log\Trace;

class AccessorException extends \Exception
{
	public function __construct($classname_str, $property, $file, $line, $code = 0, \Exception $previous = null)
	{
		Trace::add(_UFO_LOG_LOGIC_,'['.$classname_str.'] AccessorException : "'.$property.'" not exist, in file :'.$file.' at line :'.$line);
		
		parent::__construct($classname_str.':'.$property.':'.$file.':'.$line, $code, $previous);
	}
}


