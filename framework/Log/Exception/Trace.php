<?php

namespace Ufo\Log\Exception;


/**
 * 
 * @author gb-michel
 *
 */
class TraceException extends \Exception
{
	
	public function __construct( $message, $typelog_const, $code = 0, \Exception $previous)
	{
		parent::__contruct( $message, $code, $previous);
	}
}