<?php

namespace Core\Exception;


/**
 * 
 * @author gb-michel
 *
 */
class Trace extends \Exception
{
	
	public function __construct( $message, $typelog_const, $code = 0, \Exception $previous)
	{
		parent::__contruct( $message, $code, $previous);
	}
}