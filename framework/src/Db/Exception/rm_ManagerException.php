<?php

namespace Ufo\Db\Exception;

use Ufo\Log\Trace as Trace;

/**
 *
 * @author gb-michel
 *        
 */
class ManagerException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        Trace::add(_UFO_LOG_DB_,'[DB]'.$message);
    
        parent::__construct($message, $code, $previous);
    }
}

?>