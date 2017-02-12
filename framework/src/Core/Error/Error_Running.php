<?php

class Error_Running
{
	
	public function __construct( $message, $typelog_const)
	{
		Trace::add( $typelog_const, $message);
	}
	
}