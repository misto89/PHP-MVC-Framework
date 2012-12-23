<?php

/**
 * This class allows you to interface to a mysql database.
 * In particular, it allows you to query and retrieve the results as associative arrays or as objects of a specific class.
 * 
 * @author Michele Stolfa
 * @version 1.1
 */
class MySQLConnection {

	/**
	 * Indicate the active database connection.
	 * 
	 * @var resource The database connection
	 */
	private $db;
	
	/**
	 * Class constructor. Create a new connection to mysql database.
	 * 
	 * @param string $dbHost The server hosting the database
	 * @param string $dbName The database's name
	 * @param string $dbUser The username that has privileges to access the database
	 * @param string $dbPass The user's password
	 * @throws Exception If an error occurs trying to connect to the database
	 */
	public function __construct($dbHost, $dbName, $dbUser, $dbPass) {

		$this->db = mysql_connect($dbHost, $dbUser, $dbPass);
		if (!$this->db)
			throw new Exception("Could not connect to database!");

		$this->db = mysql_select_db($dbName, $this->db);
		if (!$this->db)
			throw new Exception("Database '" . $dbName . "' not found!");

	}

	/**
	 * Execute the query represented by the input parameter.
	 * 
	 * @param string $string The query string
	 * @return boolean|resource The result of the query, or false if the query string in not valid
	 */
	public function execute($string) {
		return mysql_query($string);
	}

	/**
	 * Return a single row in an associative array.
	 * 
	 * @param resource $rsc The result of execute($string) method
	 * 
	 * @return boolean|associative array: false if query returns an empty set or if the query is not valid. Else return an associative array
	 */
	public function fetch_assoc($rsc) {
		if (!$rsc)
			return false;

		return mysql_fetch_assoc($rsc);
	}

	/**
	 * Return a set of row in an array of associative arrays. Each associative array representing one row of the set.
	 * 
	 * @param resource $rsc The result of execute($string) method
	 * @return boolean|array: false if query returns an empty set or if the query is not valid. Else return an array of associative arrays
	 */
	public function fetch_all_assoc($rsc) {

		if (!$rsc || mysql_num_rows($rsc) == 0)
			return false;

		$result = array();
		while ($row = mysql_fetch_assoc($rsc)) {
			array_push($result, $row);
		}

		return $result;
	}

	/**
	 * Return an object of class $classname that represent a single row.
	 * 
	 * @param resource $rsc The result of execute($string) method
	 * @param string $classname The class of the object to be returned
	 * @return boolean|object: false if query returns an empty set or if the query is not valid. Else return a $classname object
	 */
	public function fetch_obj($rsc, $classname) {
		if (!$rsc)
			return false;

		return mysql_fetch_object($rsc, $classname);
	}

	/**
	 * Return a set of row in an array of $classname objects. Each object representing one row of the set.
	 * 
	 * @param resource $rsc The result of execute($string) method
	 * @param string $classname The class of the objects to be returned
	 * @return boolean|array: false if query returns an empty set or if the query is not valid. Else return an array of $classname objects.
	 */
	public function fetch_all_obj($rsc, $classname) {
		if (!$rsc || mysql_num_rows($rsc) == 0)
			return false;

		$result = array();
		while ($row = mysql_fetch_object($rsc, $classname)) {
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
		return mysql_num_rows($rsc);
	}
	
	/**
	 * Return mysql error message.
	 * 
	 * @param resource $resource The resource after query execution [optional].
	 * @return string The generated error
	 */
	public function get_error($resource = null) {
		if ($resource == null)
			return mysql_error();
		else
			return mysql_error($resource);
	}
	
	/**
	 * Class destructor. Close database connection.
	 */
	public function __destruct() {
		@mysql_close($this->db);
	}
}