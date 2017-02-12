<?php
namespace Ufo\Error;

use Ufo\Log\Trace as Trace;

/**
 * ImportException is catch if a file not exists, access is denied, etc... 
 * 
 * @author gb-michel
 *        
 */
abstract class ImportException extends \Exception
{
    
    /**
     * Try to detect origin a issues
     * 
     * @param unknown $message
     * @param unknown $fileURI_str
     * @param string $detected_bool
     * @param number $code
     * @param \Exception $previous
     * 
     * @author GBM
     * @since 2013/12/19
     * @version 2.0
     */
    public function __construct($message, $fileURI_str, $detected_bool = false, $code = 0, \Exception $previous = null)
    {
        if( $detected_bool === true){
            Trace::add(_UFO_LOG_LOGIC_,'['.__CLASS__.'][IMPORT] on '.$fileURI_str.' : '.$this->__toString());
            parent::__construct($message, $code, $previous);
        }
        else{
            
            // if type is null, causes of crash are undefined
            // we try to detect 
            if( !file_exists($fileURI_str)){
                Trace::add(_UFO_LOG_LOGIC_,'['.__CLASS__.'][IMPORT] on '.$fileURI_str.' : (detection) > File not exists');
                parent::__construct($message, $code, $previous);
            }
            
            $f = stat($fileURI_str);
            if( $f===false){
                Trace::add(_UFO_LOG_LOGIC_,'['.__CLASS__.'][IMPORT] on '.$fileURI_str.' : (!) Detection failed');
                parent::__construct($message, $code, $previous);
            }
            else{
                // Check if size is sup to 0
                if($f[7]==0){
                    Trace::add(_UFO_LOG_LOGIC_,'['.__CLASS__.'][IMPORT] on '.$fileURI_str.' : (detection) File exists but is empty');
                    parent::__construct($message, $code, $previous);
                }
                else{
                    Trace::add(_UFO_LOG_LOGIC_,'['.__CLASS__.'][IMPORT] on '.$fileURI_str.' : (detection) File permissions '.sprintf("0%o", 0777 & $f['mode']));
                    parent::__construct($message, $code, $previous);
                }
            }
        }
    }
    

    /**
     * (non-PHPdoc)
     * @see Exception::__toString()
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    } 
}

?>