<?php
namespace Ufo\Entity\Db\Exception;

use Ufo\Log\Trace;

/**
 *
 * @author gb-michel
 *        
 */
class EntityException extends \Exception
{
    const FIELD_EMPTY = 1;
    const FIELD_INVALID_DATA = 2;
    const DB_QUERY_SELECT_FAILED = 3;
    const DB_QUERY_UPDATE_FAILED = 4;
    const DB_QUERY_DELETE_FAILED = 5;
    const DB_QUERY_SEARCH_FAILED = 6;
    const DB_QUERY_CUSTOM_FAILED = 7;
    const DELETE_FAILED = 8;
    const INVALID_COLUMN_LINK = 9;
    const INVALID_ENTITY_ADAPTER = 10;
    const CHECK_DATA_FAILED = 11;
    const ASSIGNATION_FAILED = 12;
    
    protected $custom_message = '';
    protected $current_method = '';
    protected $current_class = '';

    /**
     * 
     * @param unknown $code_int
     * @param unknown $additional_str
     */
    public function runCode( $code_int, $additional_str = '')
    {
        $start = '[DB ENTITY] ** '.$this->current_class.' ** ';
        
        switch($code_int)
        {
        	case self::FIELD_EMPTY:
                $this->custom_message = 'Field is empty';
                break;
            case self::FIELD_INVALID_DATA:
                $this->custom_message = 'Field contains invalid data';
                break;
            case self::DB_QUERY_SELECT_FAILED:
                $this->custom_message = 'SQL Query SELECT failed in EntityAbstract::getByID()';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY] SQL Query SELECT failed in EntityAbstract::getByID(), PDOException : '.$additional_str);
                break;
            case self::DB_QUERY_UPDATE_FAILED:
                $msg = $start.'SQL Query UPDATE failed in EntityAbstract::'.$this->current_method.'()';
                
                $this->custom_message = $msg.'with =>'.$this->current_arg.'';
                Trace::add(_UFO_LOG_DB_,$msg);
                break;
            case self::DELETE_FAILED:
            case self::DB_QUERY_DELETE_FAILED:
                $this->custom_message = 'SQL Query DELETE failed in EntityAbstract::delete()';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY]'.$this->custom_message );
                break;
            case self::DB_QUERY_SEARCH_FAILED:
                $this->custom_message = 'SQL Query SELECT failed in EntityAbstract::search()';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY]'.$this->custom_message );
                break;
            case self::DB_QUERY_CUSTOM_FAILED:
                $this->custom_message = 'custom SQL Query  failed in EntityAbstract::delete()';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY]'.$this->custom_message );
                break;
            case self::INVALID_COLUMN_LINK:
                $this->custom_message = 'Cannot get ColumnLinks';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY]'.$this->custom_message );
                break;
            case self::INVALID_ENTITY_ADAPTER:
                $this->custom_message = 'Cannot get EntityAdapter';
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY]'.$this->custom_message );
                break;
            case self::CHECK_DATA_FAILED:
                $this->custom_message = '['.$this->current_method.'] aborted because [CHECK_DATA] failed in '.$this->current_class;
                Trace::add(_UFO_LOG_DB_,'[DB ENTITY]'.$this->custom_message );
                break;
            case self::ASSIGNATION_FAILED:
                $this->custom_message = '['.$this->current_method.'] Failed to assign property value : property not exists or not accessible in '.$this->current_class;
                Trace::add(_UFO_LOG_LOGIC_,'[DB ENTITY]'.$this->custom_message );
                break;
            default:
                $this->custom_message = 'Unknow error';
                break;
        }    
    }
    
    
    
    
    public function __construct($finalclass_str,$methodname_str, $args_array, $code = 0, \Exception $previous = null, $additionnal_msg = '')
    {
        $this->current_class = $finalclass_str;
    	$this->current_method = $methodname_str;
        $this->current_args = serialize($args_array);
        
        $this->runCode($code);
        
        $msg = '[DB ENTITY]'.$this->custom_message;
        
        Trace::add(_UFO_LOG_RUNNING_,'[DB ENTITY]'.$this->custom_message);
    
        parent::__construct($msg, $code, $previous);
    }
}

?>