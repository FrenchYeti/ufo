<?php

namespace Ufo\HTTP;



/**
 * class for one tainted string
 */
class TaintedArray extends Tainted
{
    /**
     * @var boolean
     */
    protected $autogenerated = false;
    
	/**
	 * Clean string returned if safety test fail
	 * @var string
	 */
	protected $default_data = NULL;

	/**
	 * String that is tainted
	 * @var string
	 */
	protected $data;

    protected $strict = false;

	/**
	 * Constructor of the class.
	 * @param string $data		The string that is to be tainted
	 */
	public function __construct($data=null,$default_data=null)
	{
		$this->data = $data;
		$this->default_data = $default_data;
	}



	/**
	 * Function to trigger error when trying to use a string that is tainted
	 * @return string	The string that is tainted
	 */
	public function __toString()
	{
		if (Tainted::$TaintChecking and $this->Tainted)	//If the string is tainted, then trigger the error
			trigger_error("Trying to use tainted variable without decontamination.");
		
		if($this->data == null)
			return ($this->strict==true)? false : $this->default_data;
		else 
			return $this->data;
	}
	
	/**
	 * 
	 */
	public function useStrict()
	{
	    $this->strict = true;
	    
	    return $this;
	}
	
	/**
	 *
	 */
	public function sanitizeWithCheck()
	{
	    if(count($this->data) == 0){
	        return array($this->default_data);
	    }
	    
	    $args = func_get_args();
	    $method = array_shift($args);
	    
	    $sanitized = array();
	    $c = 0;

	    
	    if( is_callable('\Ufo\Security\Check::'.$method)){
    	    foreach($this->data as $tainted)
    	    {
    	        array_unshift($args, $tainted);
 	             
	            if( call_user_func_array('\Ufo\Security\Check::'.$method, $args)){
	                $c++;
	                $sanitized[] = $tainted;
	            }
	            else{
	                $sanitized[] = $this->default_data;
	            }
	            
	            array_shift($args);
    	    }
	    }
	    else{
	        throw new TaintedSanitizerErrorExcetion();
	        return array($this->default_data);
	    }
	    
	    if($this->strict == true){
	        if( $c == count($this->data)){
	            $this->decontaminate();
	            return $this->data;
	        }
	        else{
	            return array($this->default_data);
	        }
	    }
	    else{
	        $this->data = $sanitized;
	        $this->decontaminate();
	        return $this->data;
	    }
	}
	
	
	public function sanitizeAsObjectProperty()
	{
	    if(count($this->data) == 0){
	        return array($this->default_data);
	    }
	    
		$args = func_get_args();
		$callback = array_shift($args);
		
		if(is_callable($callback)){
		    
		    $tmp_args = $sanitized = array();
		    $c = 0;
		    foreach( $this->data as $tainted)
		    {
		        $tmp_args = $args;
		        array_push($tmp_args, $tainted);
		        
		        if( call_user_func_array($callback, $args)){
		            $c++;
		        }
		        else{
		            $this->decontaminate();
		            $sanitized[] = $this->default_data;
		        }
		        
		        array_shift($args);
		    }
		}
		else{
		    throw new TaintedSanitizerErrorExcetion();
		    return array($this->default_data);
		}
		
		if($this->strict == true){
		    if( $c == count($this->data)){
		        $this->decontaminate();
		        return $this->data;
		    }
		    else{
		        return array($this->default_data);
		    }
		}
		else{
		    $this->data = $sanitized;
		    $this->decontaminate();
		    return $this->data;
		}
	}
	
	/**
	 * 
	 * @param unknown $data_mixed
	 */
	public function setDefault( $data_mixed)
	{
		$this->default_data = $data_mixed;
		
		return $this;
	}
	
	
	/**
	 * Chainable
	 */
	public function markAsAutogenerated()
	{
	   $this->autogenerated = true;   
	   
	   return $this;
	}
	
	/**
	 * 
	 */
	public function isAutogenerated()
	{
        return $this->autogenerated;
	}

    public function length()
    {
        return count($this->data);
    }
    
    public function getDefaultData()
    {
        return array($this->default_data);
    }
}

?>