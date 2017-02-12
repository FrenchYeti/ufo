<?php

namespace Ufo\Core\Error;


/**
 * 
 * @author gb-michel
 *
 */
class Trace
{
	
    /**
     * 
     * @param unknown $message
     * @param unknown $typelog_const
     */
	public function __construct( $message, $typelog_const)
	{
		//Trace::add(  $typelog_const, '[TRACE]'.$message);
	}
}