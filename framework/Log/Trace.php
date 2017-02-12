<?php

namespace Ufo\Log;


/**
 * Add to execution logs and write in log file
 * 
 * @author gb-michel
 * @version 2.0
 */
class Trace
{
    /**
     * @var string Template to use for current log
     */
	private static $templateMSG ;
	
	/**
	 * @var array Array of custom debug data to record
	 */
	private static $debug_data = array();
	
	
	/**
	 * @static
	 * @method string Select template of entry and return filename of log file to use 
	 * @param constant $param_type_int_const Type of log
	 * @return string File name
	 * @author gb-michel
	 * @version 2.0
	 * @since 16/12/2013
	 */
	private static function _getLogFilename( $param_type_int_const)
	{
		switch( $param_type_int_const)
		{
			case _UFO_LOG_DB_ :
				self::$templateMSG = ''.date('d-m-Y h:i:s').' ; $${MSG}$$ ; '.(int) ip2long( $_SERVER['REMOTE_ADDR']).'';
				$file = 'db.log';
				break ;
			case _UFO_LOG_FORM_ :
				self::$templateMSG = ''.date('d-m-Y h:i:s').' ; $${MSG}$$ ; '.(int) ip2long( $_SERVER['REMOTE_ADDR']).'';
				$file = 'frm.log';
				break ;
			case _UFO_LOG_ACCOUNT_ :
				self::$templateMSG = ''.date('d-m-Y h:i:s').' ; $${MSG}$$ ; '.(int) ip2long( $_SERVER['REMOTE_ADDR']).'';
				$file = 'account.log';
				break ;
			case _UFO_LOG_LOGIC_ :
				self::$templateMSG = ''.date('d-m-Y h:i:s').' ; $${MSG}$$ ; '.(int) ip2long( $_SERVER['REMOTE_ADDR']).'';
				$file = 'logic.log';
				break ;
			case _UFO_LOG_ACCESS_ :
				self::$templateMSG = ''.date('d-m-Y h:i:s').' ; $${MSG}$$ ; '.(int) ip2long( $_SERVER['REMOTE_ADDR']).'';
				$file = 'access.log';
				break ;
			case _UFO_LOG_ERROR_ :
				self::$templateMSG = ''.date('d-m-Y h:i:s').' ; $${MSG}$$ ; '.(int) ip2long( $_SERVER['REMOTE_ADDR']).'';
				$file = 'error.log';
				break ;
			case _UFO_LOG_RUNNING_ :
			    self::$templateMSG = ''.date('d-m-Y h:i:s').' ; $${MSG}$$ ; '.(int) ip2long( $_SERVER['REMOTE_ADDR']).'';
			    $file = 'running.log';
			    break ;
			case _UFO_LOG_SECURITY_ :
			    self::$templateMSG = ''.date('d-m-Y h:i:s').' ; $${MSG}$$ ; '.(int) ip2long( $_SERVER['REMOTE_ADDR']).'';
			    $file = 'security.log';
			    break ;
			default :
				self::$templateMSG = ''.date('d-m-Y h:i:s').' ; $${MSG}$$ ; '.(int) ip2long( $_SERVER['REMOTE_ADDR']).'';
				$file = 'default.log';
				break ;
		}
		
		return $file ;
	}
	
	/**
	 * @method void Add new entry to log file
	 * @param const $param_type_int_const CONSTANT : Type of log 
	 * @param string $param_message_str Message of log
	 * @author gb-michel
	 * @version 2.0
	 * @since 16/12/2013
	 */
	public static function add( $param_type_int_const, $param_message_str)
	{
		$file = self::_getLogFilename( $param_type_int_const);

		if( _UFO_DEBUG_MODE_ === true) echo $param_message_str.'<br>';
		
		$fp = fopen( _UFO_LOG_DIR_.$file, 'a');
		if( $fp !== false){			
			$s = str_replace( '$${MSG}$$', $param_message_str, self::$templateMSG );
			fwrite( $fp, $s."\r\n");
			fclose( $fp);
		}
	}
	
	/**
	 * @method void Dump log file to HTTP output in HTML
	 * @param const param_output_str
	 * @author gb-michel
	 * @version 2.0
	 * @since 16/12/2013
	 */
	public static function dumpHTML( $param_type_int_const)
	{
		$file = self::_getLogFilename( $param_type_int_const);

		if( file_exists( _UFO_LOG_DIR_.$file)){					
			echo file_get_contents( _UFO_LOG_DIR_.$file);
		}
	}
	
	/**
	 * @method void Add a new data to record in debug context
	 * @param string $tag_str Tag name of data
	 * @param mixed $data_mixed Data to record
	 * @author gb-michel
	 * @version 2.0
	 * @since 16/12/2013
	 */
	public static function addDebugData( $tag_str, $data_mixed)
	{
	    if( isset(self::$debug_data[$tag_str])){
	         
	        if( !is_array(self::$debug_data[$tag_str])){
	            $tmp = array();
	            $tmp[] = self::$debug_data[$tag_str];
	            self::$debug_data[$tag_str] = $tmp;
	        }
	        else{
	            self::$debug_data[$tag_str][] = $data_mixed;
	        }
	    }
	    else{
	        self::$debug_data[$tag_str] = $data_mixed;
	    }
	     
	}
	
	
	/**
	 * @method boolean Check if custom debug data exists
	 * @param string $tag_str Tag name of the custom debug data
	 * @return boolean Return TRUE if data is set, else FALSE
	 * @author gb-michel
	 * @version 2.0
	 * @since 16/12/2013
	 */
	public static function issetDebugData( $tag_str)
	{
	    return isset(self::$debug_data[$tag_str]);
	}
	
	/**
	 * @method void Pass custom debug data identified by them tag name to var_dump() method
	 * @param string $tag_str Tag name of debug data
	 * @author gb-michel
	 * @version 2.0
	 * @since 16/12/2013
	 */
	public static function dumpDebugData( $tag_str = null)
	{
	    if( !is_null($tag_str)
	    && isset(self::$debug_data[$tag_str])){
	         
	        var_dump(self::$debug_data[$tag_str]);
	    }
	    else{
	        var_dump(self::$debug_data);
	    }
	}
	
	
	
	/**
	 * 
	 */
	public static function truncate()
	{
		$logs_files = scandir(_UFO_LOG_DIR_);
		
		$f = $c = 0;
		foreach( $logs_files as $file)
		{
			if( $file[0] !== '.'){
				$fh = fopen(_UFO_LOG_DIR_.$file,'w');
				if( $fh !== false){
					ftruncate( $fh, filesize(_UFO_LOG_DIR_.$file));
					$f++;
				}
				$c++;
			}
		}
		
		return ($f == $c)? true : false ;
	} 
}

?>