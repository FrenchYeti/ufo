<?php

namespace Ufo\Db;

use Ufo\Error\DbException as DbException;

/**
 *
 * @author gb-michel
 *
 */
class ConnexionException extends DbException
{
    public function __construct( $calledmethod_str = '', $message_str = '', $code = DbException::STANDARD_LVL)
    {
        parent::__construct('Ufo\Db\Connexion',' 
            -- On : <i>'.$calledmethod_str.'</i> <br>
            -- Exception caught : <i>'.get_class($this).'</i> <br>
            -- Message : <i>'.$message_str.'</i><br>
            -- File : '.$this->getFile().' at line :'.$this->getLine().'<br>
        ',$code);
    }
}


class DatabaseNotSetException extends ConnexionException {}
class RequestNotSupportedException extends ConnexionException {}

/**
 * 
 * @author gb-michel
 *
 */
class Connexion
{
	private $_PDO = null ;
	private $_casesensitive = false;
		
	/**
	 * 
	 * @param unknown $profilename_obj
	 * @return boolean
	 */
	public function __construct($profile_obj)
	{
	    if( !($profile_obj instanceof Profile )){
	        return false;
	    }
	    
	    $this->_casesensitive = $profile_obj->getCASE();
	    
		if( $this->_PDO == null){

			try{
			   
			   $this->_PDO = new \PDO( 
			       $profile_obj->getDBMS().':host='.$profile_obj->getSERVER().';dbname='.$profile_obj->getNAME().'', 
			       $profile_obj->getUSER(), $profile_obj->getPASS()
               );
			   
			   if( !is_null($this->_PDO)){
			   		$this->_PDO->exec('SET NAMES utf8');
			   }
			   
			} catch( \PDOException $e) {
			   
			    $msg = time().';'.date('Y-m-d H:i:s').';'.$e->getCode().';'.$e->getMessage().';'.$e->getFile().';'.$e->getLine() ;
			    throw new ConnexionException('Connexion::__construct()','Connexion to DB failed : '.$msg,DbException::FATAL_LVL);
			}
		}
	}
	
	
	public function __clone(){} 
	
	
	public function __destruct(){}
	
	/**
	 * 
	 * @return \PDO|boolean
	 */
	public function getHandler()
	{
		if( $this->_PDO !== null){
			return $this->_PDO ;
		}
		else{
			return false ;
		}
	}
	
	
	
    /**
     * @method string Manage case sensitive
     * @param string $value_str
     * @return string
     * @version 2.0
     * @since 17/12/2013
     * @author GBMichel
     */
	public function manageCase($value_str)
	{
		if( $this->_casesensitive === 'UP'){
			return strtoupper($value_str);
		}
		elseif( $this->_casesensitive === 'LOW'){
			return strtolower($value_str);
		}		
		else{
			return $value_str;
		}
	}
	
	
	/**
	 * Function to return the id of the last row that was inserted in the DB
	 * @return int		ID of the last row inserted
	 */
	public function lastInsertId()
	{
		return $this->_PDO->lastInsertId();
	}
	
	
	
	/**
	 * Function to execute an SQL statement
	 * From PHPSEC and adapted to UFO
	 * 
	 * @param string $query		The query to be executed
	 * @return int | array | null	It may return last insert ID, or row count, or an array containing the results, or null.
	 * @throws DatabaseNotSet	Thrown in case trying to execute a SQL statement when connection to DB is not set
	 */
	public function SQL($query)
	{
		//If the DB connection is still empty, then throw an error
		if ($this->_PDO === NULL) {
			throw new DatabaseNotSetException('Connexion::SQL()',"Database is not set/configured properly.",DbException::FATAL_LVL);
		}
	
		try{
    		$args = func_get_args ();	//get the arguments to this function
    		array_shift ($args);		//remove the first argument as that contains the actual "QUERY"
    		$statement = $this->prepare ($query);	//Prepares an SQL statement to be executed by the PDOStatement::execute() method. Returns a PDOStatement object.
    	
    		if (!empty ($args[0]))		//If arguments are passed, then check if the first argument is an array. If yes, then that array contains all the arguments
    		{
    			if (is_array ($args[0]))
    			{
    				$statement->execute ($args[0]);		//Execute the statement with this array
    			}
    			elseif (count ($args) >= 1)		//If there are more than 1 arguments, then call the "bindall" function of the class DatabaseStatementModel to call PDO's function bindValue to bind the parameters to the ? in the query
    			{
    				call_user_func_array (array ($statement, "bindAll"), $args);
    				$statement->execute ();
    			}
    		}
    		else
    		{
    			$statement->execute ();		//If no arguments are passed, then execute the query with empty arguments
    		}
    	
    		$type = substr (trim (strtoupper ($query)), 0, 3);	//get the first three letters of the query
    		if ($type == "INS")	//If the query is of insert type
    		{
    			$res = $this->LastInsertId();	//Then return the last insert ID
    			if ($res == 0)		//If nothing is inserted, then return the number of rows affected by the corresponding PDOStatement object.
    			{
    				return $statement->rowCount();
    			}
    				
    			return $res;
    		}
    		elseif ($type == "DEL" or $type == "UPD")	//If the query is delete or update, then returns the number of rows affected by the corresponding PDOStatement object.
    		{
    			return $statement->rowCount();
    		}
    		elseif ($type == "SEL")				//If query is select type, then return all the rows returned by the DB
    		{
    			return $statement->fetchAll();
    		}
    		
    		return null;
		}
		catch( \PDOException $e){
		    if( _UFO_DEBUG_MODE_ === true){
		        echo('-- On : <i>'.$e->getCode().'</i> <br>
                      -- Message : <i>'.$e->getMessage().'</i><br>
                      -- File : '.$this->getFile().' at line :'.$this->getLine().'<br>');
		    }
		    return null;
		}
	}
	
	
	
	/**
	 * Function to call PDO::query() to execute an SQL statement in a single function call.
	 * @param string $query			Statement to execute
	 * @return \PDOStatement		Returns the result set (if any) returned by the statement as a PDOStatement object.
	 */
	public function query($query)
	{
		return $this->_PDO->query($query);
	}
	
	
	
	/**
	 * Function to call PDO::exec() to execute an SQL statement in a single function call.
	 * @param string $query			Statement to execute
	 * @return int				Returns the number of rows affected by the statement.
	 */
	public function exec($query)
	{
		return $this->_PDO->exec($query);
	}
	
	/**
	 * Function to prepare the query. It prepares an SQL statement to be executed by the PDOStatement::execute() method.
	 * @param string $query					The string to be executed
	 * @return \phpsec\DatabaseStatement_pdo_mysql		Returns the object of type \phpsec\DatabaseStatement_pdo_mysql
	 */
	public function prepare($query)
	{
		return new Statement($this, $query);
	}
}

?>