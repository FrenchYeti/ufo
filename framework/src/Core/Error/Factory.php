<?php

/**
 * Exception de la classe Factory,
 * Factory est le design pattern Fabrique, utilise
 * pour cree les exceptions specifique a une classe en cas d'erreur
 * @author GB Michel
 * @version 1.0
 * @since 25/11/2012
 */
class Factory
{	
	public function __construct( $message)
	{
		Trace::add( _UFO_LOG_LOGIC_, $message);
		//Trace::add( ERROR_CRITICAL, $message);
	}	
}