<?php

namespace Ufo\Db;


/**
 * DatabaseStatementModel class.
 * Intended as parent for all database prepared statement classes.
 */
class Statement
{



	/**
	 * Object of type DatabaseModel
	 * @var \phpsec\DatabaseModel
	 */
	protected $db;



	/**
	 * The query to be executed
	 * @var string
	 */
	protected $query;



	/**
	 * Parameters to the query to be executed
	 * @var array
	 */
	protected $params;



	/**
	 * PDOStatement object.
	 * @var \PDOStatement
	 */
	protected $statement;



	/**
	 * Constructor of the class to set DB connection, query and statement
	 * @param \phpsec\DatabaseModel $db
	 * @param string $query
	 */
	public function __construct( Connexion $db, $query)
	{
		$this->db = $db;
		$this->query = $query;
		$this->statement = $db->getHandler()->prepare($query);
	}



	/**
	 * Destructor of the class
	 */
	public function __destruct ()
	{
		if (isset($this->statement))
		{
			$this->db = NULL;
			$this->query = NULL;
			$this->params = NULL;
			$this->statement = NULL;
		}
	}



	/**
	 * Fetches a row from a result set associated with a PDOStatement object.
	 * @return \PDO::FETCH_ASSOC		The fetch_style parameter determines how PDO returns the row.
	 */
	public function fetch ()
	{
		return $this->statement->fetch (\PDO::FETCH_ASSOC);
	}



	/**
	 * Fetches all rows from a result set associated with a PDOStatement object.
	 * @return \PDO::FETCH_ASSOC		The fetch_style parameter determines how PDO returns the row.
	 */
	public function fetchAll()
	{
		return $this->statement->fetchAll (\PDO::FETCH_ASSOC);
	}



	/**
	 * Binds a value to a corresponding named or question mark placeholder in the SQL statement that was used to prepare the statement.
	 */
	public function bindAll ()
	{
		$params = func_get_args ();
		$this->params = $params;
		$i = 0;
		foreach ($params as &$param) {
			$this->statement->bindValue (++$i, $param);	//call the PDO's bindValue method to bind the value
		}
	}



	/**
	 * Execute the prepared statement.
	 * @return boolean	Returns TRUE on success or FALSE on failure.
	 */
	public function execute ()
	{
		$args = func_get_args ();	//get all user arguments
		if (!empty ($args[0]) && is_array ($args[0]))	//If the argument contains an array that contains all the parameters, then execute the statement with all those parameters
			return $this->statement->execute ($args[0]);
		else
			return $this->statement->execute ();	//If the argument does not contain any parameter, then execute the statement without any parameters
	}



	/**
	 * Returns the number of rows affected by the last DELETE, INSERT, or UPDATE statement executed by the corresponding PDOStatement object.
	 * @return int		Number of rows affected
	 */
	public function rowCount ()
	{
		return $this->statement->rowCount ();
	}
}

?>