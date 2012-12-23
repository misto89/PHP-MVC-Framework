<?php

/**
 * This class allows you to interface to a postgresql database.
 * In particular, it allows you to query and retrieve the results as associative arrays or as objects of a specific class.
 *
 * @author Michele Stolfa
 * @version 1.1
 */
class PostgreSQLConnection {
	
	/**
	 * Indicate the active database connection.
	 *
	 * @var resource The database connection
	 */
	private $db;
	
	/**
	 * Class constructor. Create a new connection to postgresql database.
	 *
	 * @param string $dbHost The server hosting the database
	 * @param string $dbName The database's name
	 * @param string $dbUser The username that has privileges to access the database
	 * @param string $dbPass The user's password
	 * @throws Exception If an error occurs trying to connect to the database
	 */
	public function __construct($dbHost, $dbName, $dbUser, $dbPass) {
	
		$connection_string = "host=" . $dbHost . " dbname=" . $dbName . " user=" . $dbUser .
			" password=" . $dbPass . " options='--client_encoding=UTF8'";
		
		$this->db = pg_connect($connection_string);
		
		if (!$this->db)
			throw new Exception("Could not connect to database!");
		
	}
	
	/**
	 * Execute the query represented by the input parameter.
	 *
	 * @param string $string The query string
	 * @param array An array of parameters
	 * @return boolean|resource The result of the query, or false if the query string in not valid
	 */
	public function execute($string, $params = null) {
		if ($params == null) {
			return pg_query($this->db, $string);
		} else {
			return pg_query_params($this->db, $string, $params);
		}
	}
	
	/**
	 * Return a single row in an associative array.
	 *
	 * @param resource $rsc The result of execute($string, $params = null) method
	 *
	 * @return boolean|associative array: false if query returns an empty set or if the query is not valid. Else return an associative array
	 */
	public function fetch_assoc($rsc) {
		if (!$rsc)
			return false;
	
		return pg_fetch_assoc($rsc);
	}
	
	/**
	 * Return a set of row in an array of associative arrays. Each associative array representing one row of the set.
	 *
	 * @param resource $rsc The result of execute($string, $params = null) method
	 * @return boolean|array: false if query returns an empty set or if the query is not valid. Else return an array of associative arrays
	 */
	public function fetch_all_assoc($rsc) {
	
		if (!$rsc || pg_num_rows($rsc) == 0)
			return false;
	
		return pg_fetch_all($rsc);
	}
	
	/**
	 * Return an object of class $classname that represent a single row.
	 *
	 * @param resource $rsc The result of execute($string, $params = null) method
	 * @param string $classname The class of the object to be returned
	 * @return boolean|object: false if query returns an empty set or if the query is not valid. Else return a $classname object
	 */
	public function fetch_obj($rsc, $classname) {
		if (!$rsc)
			return false;
	
		return pg_fetch_object($rsc, null, $classname);
	}
	
	/**
	 * Return a set of row in an array of $classname objects. Each object representing one row of the set.
	 *
	 * @param resource $rsc The result of execute($string, $params = null) method
	 * @param string $classname The class of the objects to be returned
	 * @return boolean|array: false if query returns an empty set or if the query is not valid. Else return an array of $classname objects.
	 */
	public function fetch_all_obj($rsc, $classname) {
		if (!$rsc || pg_num_rows($rsc) == 0)
			return false;
	
		$result = array();
		while ($row = pg_fetch_object($rsc, null, $classname)) {
			array_push($result, $row);
		}
	
		return $result;
	}
	
	/**
	 * Get number of rows in $rsc.
	 *
	 * @param resource $rsc The resource
	 * @return integer number of rows on success, false for failure
	 */
	public function num_rows($rsc) {
		$num = pg_num_rows($rsc);
		if ($num == -1)
			return false;
		
		return $num;
	}
	
	/**
	 * Return postgres error message.
	 *
	 * @param resource $resource The resource after query execution [optional].
	 * @return string The generated error
	 */
	public function get_error($resource = null) {
		if ($resource == null)
			return pg_last_error($this->db);
		else
			return pg_result_error($result);
	}
	
	/**
	 * Class destructor. Close database connection.
	 */
	public function __destruct() {
		@pg_close($this->db);
	}
	
}