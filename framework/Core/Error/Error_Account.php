<?php

class Error_Account
{
	public $msg = array(
	    'eject'=>'[USER] Restoration failed, user disconnected.'
	);
    
    
	public function __construct( $message, $typelog_const, $msg_code = null)
	{
	    if( !is_null($msg_code)){
	        Trace::add( $typelog_const, '[ACCOUNT]'.$message.$this->msg[$msg_code]);
	    }
	    else{
	        Trace::add( $typelog_const, '[ACCOUNT]'.$message);
	    }
		
	}
	
}