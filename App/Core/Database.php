<?php namespace App\Core;

use \App\Core\Config;
use \PDO;

class Database {

	/**
	 * PDO options.
	 * 
	 * @var array
	 */
	protected $options = [
		PDO::ATTR_PERSISTENT => true,
		PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
	];

	/**
	 * Database instance.
	 * 
	 * @var Database
	 */
	protected static $instance;

	/**
	 * Active database connection.
	 * 
	 * @var PDO
	 */
	protected $conn;

	/**
	 * Current statement.
	 * 
	 * @var mixed
	 */
	protected $stmt;

	/**
	 * Constructor.
	 */
	public function __construct()
	{

		if( is_null(static::$instance) ){

			Config::load('database');
			static::$instance = $this;

		}

		return static::$instance;

	}

	/**
	 * Build the database source name string.
	 * 
	 * @return string
	 */
	protected function dsn()
	{
		return 'mysql:host='.Config::get('database', 'hostname').';dbname='.Config::get('database', 'database');
	}

	/**
	 * Create a connection if one's not already defined.
	 * 
	 * @return PDO
	 */
	public function connection()
	{

		if( is_null($this->conn) ){

			$this->conn = new PDO(
				$this->dsn(),
				Config::get('database', 'username'),
				Config::get('database', 'password'),
				$this->options
			);

		}

		return $this->conn;

	}

	/**
	 * Prepare a PDO statement from a query.
	 * 
	 * @param  string $query
	 * @return self
	 */
	public function query($query)
	{
		$this->stmt = $this->connection()->prepare($query);
		return $this;
	}

	/**
	 * Bind any parameters to the statement.
	 * 
	 * @param  string $param
	 * @param  mixed  $value
	 * @param  mixed  $type
	 * @return self
	 */
	public function bind($param, $value, $type = null)
	{

		if( is_null($type) ){

			switch(true){
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}

		}

		$this->stmt->bindValue($param, $value, $type);

		return $this;

	}

	/**
	 * Execute the PDO statement.
	 * 
	 * @return self
	 */
	public function execute()
	{
		return $this->stmt->execute();
	}

	/**
	 * Return all the result set.
	 * 
	 * @return mixed
	 */
	public function getAll()
	{
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}

	/**
	 * Return a single result.
	 * 
	 * @return mixed
	 */
	public function getSingle()
	{
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_OBJ);
	}

	/**
	 * Return the total count of the rows found.
	 * 
	 * @return int
	 */
	public function getCount()
	{
		$this->execute();
		return $this->stmt->rowCount();
	}

	/**
	 * Return the last inserted ID.
	 * 
	 * @return int
	 */
	public function getLastInsertId()
	{
		return $this->connection()->lastInsertId();
	}

}
