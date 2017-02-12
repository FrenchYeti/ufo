<?php
namespace Ufo\HTTP;


class TaintedSanitizerErrorExcetion extends \Exception {};


/**
 * Abstract class for all tainted string
 */
class Tainted
{
	
	
	
	/**
	 * Enables/Disables the taint checking function
	 * @var boolean		True enables the taint checking function. False disables it 
	 */
	public static $TaintChecking = true;
	
	
	
	/**
	 * To indicate that the string is tainted
	 * @var boolean		True means the string is tainted. False otherwise
	 */
	protected $Tainted = true;
	
	
	
	/**
	 * To tell if the given Tainted Object is tainted or not
	 * @param \phpsec\Tainted $Object	The Tainted class object
	 * @return boolean			Returns true if the string is tainted. False otherwise
	 */
	public static function Is(Tainted $Object)
	{
		return $Object->Tainted;
	}

	
	/**
	 * To decontaminate a "Tainted" object
	 */
	public function decontaminate()
	{
		$this->Tainted = false;
	}

	
	
	/**
	 * To taint a string i.e. to contaminate it.
	 */
	public function contaminate()
	{
		$this->Tainted = true;
	}

}



