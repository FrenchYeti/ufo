<?php
namespace Ufo\Log\Workers;


abstract class Template
{
	
	
	/**
	 * This variable holds the template.
	 * @var Array	An array to hold the template.
	 */
	public $template = array(
	    "MESSAGE"	=> "",
	    "TYPE"	=> "",
	    "PRIORITY"	=> "",
	    "DATETIME"	=> "",
	    "FILENAME"	=> "",
	    "LINE"	=> "",
	);
	
	
	
	/**
	 * Function to set default values in the template.
	 */
	protected function setDefaults()
	{
		$backtrace = debug_backtrace();	//get backtrace to know which file called this function.
		
		$fileGeneratingLog = "";
		$lineGeneratingLog = "";
		foreach ($backtrace as $func)
		{
			if ( strpos($func['class'], 'Logger') )		//Array in backtrace that will contain the class "Logger" is the file that originally called this function.
			{
				$fileGeneratingLog = $func['file'];	//get the appropriate filename from the backtrace
				$lineGeneratingLog = $func['line'];	//get the appropriate line from the backtrace
				break;
			}
		}
		
		//set the default value.
		$this->template["FILENAME"] = $fileGeneratingLog;
		$this->template["LINE"] = $lineGeneratingLog;
		$this->template["TYPE"] = "ERROR";
		$this->template["PRIORITY"] = "NORMAL";
                $this->template["DATETIME"] = date("m-d-Y H:i:s", \Ufo\Core\time());
	}
	
	
	/**
	 * Abstract function that must be implemented by each media class to log data.
	 */
	abstract public function log($args);
	
	
	/**
	 * Abstract function that must be implemented by each media class to manipulate template acording to their needs.
	 */
	abstract protected function changeTemplate($args);
}