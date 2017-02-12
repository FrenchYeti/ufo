<?php 

namespace Ufo\HTTP;

class TaintedCollection extends \Ufo\Core\Collection
{
	/* (non-PHPdoc)
	 * @see \Ufo\Core\Collection::__construct()
	 */
	public function __construct() 
	{}
	
	/**
	 * To get tainted objects
	 * 
	 * @return multitype:Ambigous <multitype:, NULL, unknown>
	 */
	public function getTainted()
	{
	    $tainted = array();
	    
        foreach($this->objects as $o)
        {
            if(Tainted::Is($o)) $tainted[] = $o;    
        }
        
        return $tainted;
	}

	/**
	 * To get cleaned objects
	 * 
	 * @return multitype:Ambigous <multitype:, NULL, unknown>
	 */
	public function getCleaned()
	{
	    $cleaned = array();
	     
	    foreach($this->objects as $o)
	    {
	        if(!Tainted::Is($o)) $cleaned[] = $o;
	    }
	
	    return $cleaned;
	}	
}

?>