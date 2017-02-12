<?php

namespace Ufo\Log\Exception;

use Ufo\Error\StandardException;


/**
 * 
 * @author gbmichel
 *
 */
class LogException extends StandardException
{
	public function __construct($message_str)
	{
		parent::__construct('Ufo\Log\Logger',$message_str);
	}
}


?>