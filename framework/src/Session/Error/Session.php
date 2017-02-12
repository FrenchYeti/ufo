<?php

namespace Ufo\Session\Error;

use Ufo\Log\Trace as Trace;

/**
 * 
 * @author gb-michel
 *
 */
class Session
{
    
	/**
	 * 
	 * @param unknown $message
	 * @param unknown $typelog_const
	 */
	public function __construct( $message, $typelog_const)
	{
		Trace::add( $typelog_const, '[SESSION]'.$message);
	}
	
}