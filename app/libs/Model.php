<?php

/**
 * This class provides the basic methods of a Model.
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class Model {

	/**
	 * Fetch a single row as an associative array.
	 * 
	 * @var string
	 */
	public static $FETCH_ASSOC = "fetch_assoc";
	
	/**
	 * Fetch a set of rows as an array of associative arrays.
	 * 
	 * @var string/**
	 * 
	 */
	
	public static $FETCH_ALL_ASSOC = "fetch_all_assoc";
	
	/**
	 * Fetch a single row as an object.
	 * 
	 * @var string
	 */
	public static $FETCH_OBJ = "fetch_obj";
	
	/**
	 * Fetch a set of rows as an array of objects.
	 * 
	 * @var string
	 */
	public static $FETCH_ALL_OBJ = "fetch_all_obj";
	
	/**
	 * The active database connection.
	 * 
	 * @var resource
	 */
	private $_db;
	
	/**
	 * Initializes the basic model.
	 */
	function __construct() {
				
		if (DB_TYPE == 'mysql')
			$this->_db = new MySQLConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
		else if (DB_TYPE == 'psql')
			$this->_db = new PostgreSQLConnection(DB_HOST, DB_NAME, DB_USER, DB_PASS);
					
		if (!$this->_db) 
			throw new Exception("Connection failed!");
	
	}

	/**
	 * Insert a new row in a table.
	 * 
	 * @param string $table_name The table where to insert the new row.
	 * @param array $assoc_array Contains the new row in this form: array('field' => $value).
	 * @return boolean: true if the insertion is successful, false otherwise.
	 */
	public function insert($table_name, $assoc_array) {

		//Pre-condition
		if (!is_array($assoc_array))
			return false;
		
		ksort($assoc_array);
		$arrayValues = array_values($assoc_array);
		for ($i = 0; $i < count($arrayValues); $i++) {
			$arrayValues[$i] = escape_string($arrayValues[$i]);
		}
		
		$fields = implode(' , ', array_keys($assoc_array));
		$values = implode("', '", $arrayValues);

		$query = "INSERT INTO $table_name ($fields) VALUES ('$values')";

		$result = $this->query($query, null);

		if (!$result) {
			throw new QueryException($this->_db->get_error());
		}

		return true;

	}

	/**
	 * Execute a sql query, possibly fetch and return the results.
	 * 
	 * @param string $sql_string The sql string to be executed
	 * @param string $fetchMode How to return the results, or null if the query is an insert, update or delete query.
	 * @param string $classname If fetch returns objects, indicate the class name of this objects.
	 * @return false if the execution isn't successful, the results otherwise.
	 */
	public function query($sql_string, $fetchMode, $classname = null) {
		
		//Pre-condition
		if ($fetchMode != null) {
			if ($fetchMode != Model::$FETCH_ALL_ASSOC && $fetchMode != Model::$FETCH_ALL_OBJ && 
					$fetchMode != Model::$FETCH_ASSOC && $fetchMode != Model::$FETCH_OBJ) {
				
				return false;
			}
		} 
		
		$result = $this->_db->execute($sql_string);

		if (!$result)
			throw new QueryException($this->_db->get_error());

		if ($fetchMode == null)
			return true;
		
		return $this->_db->$fetchMode($result, $classname);

	}
	
	/**
	 * Execute a select query, without explicitly indicate the string. Then fetch and return the results.
	 * 
	 * @param array $fields A list of fields to select in this form: array('field1', 'field2') or array('*') for all fields.
	 * @param array $from A list of tables from which to retrieve results, for example array('table1', 'table2').
	 * @param array $join If $from contains more than one table, indicates the associations between this tables in this form:
	 * 	array('table1_field' => 'table2_field'). null if this clause isn't present.
	 * @param array $where The where clause of the query in this form: array('field' => $value). null if this clause isn't present.
	 * @param array $order A list of fields by which to sort the results, for example array('field1', 'field2'). null if this clause isn't present.
	 * @param string $fetchMode How to return the results.
	 * @param string $classname Optional: if fetch returns objects, indicate the class name of this objects.
	 * @return false if the execution isn't successful, the results otherwise.
	 */
	public function select($fields, $from, $join, $where, $order, $fetchMode, $classname = null) {
		
		//Pre-conditions
		if ($fetchMode != Model::$FETCH_ALL_ASSOC && $fetchMode != Model::$FETCH_ALL_OBJ && 
				$fetchMode != Model::$FETCH_ASSOC && $fetchMode != Model::$FETCH_OBJ)
			
			return false;
		
		if (!is_array($fields))
			return false;
		
		if (!is_array($from))
			return false;
		
		if ($join != null && !is_array($join))
			return false;
		
		if ($where != null && !is_array($where))
			return false;
		
		if ($order != null && !is_array($order))
			return false;
		
		//Body
		$fieldString = implode(', ', $fields);
		$fromString = implode(', ', $from);
		
		$query = "SELECT $fieldString FROM $fromString";
		
		if ($join != null) {
			$joinString = "";
			
			foreach ($join as $key => $value) {
				$joinString .= "$key = $value AND ";
			}
			
			$joinString = rtrim($joinString, ' AND ');
			$query .= " WHERE $joinString";
		}
		
		if ($where != null) {
			$whereString = "";
				
			foreach ($where as $key => $value) {
				$whereString .= "$key = '" . escape_string($value) . "' AND ";
			}
				
			$whereString = rtrim($whereString, ' AND ');
			if ($join != null)
				$query .= " AND $whereString";
			else
				$query .= " WHERE $whereString";
		}
		
		if ($order != null) {
			$orderString = implode(', ', $order);
			$query .= " ORDER BY $orderString";
		}

		return $this->query($query, $fetchMode, $classname);
	}

	/**
	 * Update one or more rows.
	 * 
	 * @param string $table_name The table to update.
	 * @param array $data The data to update in this form: array('field', $value)
	 * @param array $assoc_array_where Optional: the where clause of the query in this form: array('field' => $value).
	 * @return boolean true if the update is successful, false otherwise.
	 */
	public function update($table_name, $data, $assoc_array_where = null) {

		//Pre-conditions
		if (!is_array($data))
			return false;
		
		if ($assoc_array_where != null && !is_array($assoc_array_where))
			return false;
		
		//Body
		ksort($data);

		$fieldDetails = NULL;
		foreach($data as $key=> $value) {
			$fieldDetails .= "$key = '" . escape_string($value) . "',";
		}
		$fieldDetails = rtrim($fieldDetails, ',');
	
		$query = "UPDATE $table_name SET $fieldDetails";
		
		if ($assoc_array_where != null) {
			$where = "";
			foreach ($assoc_array_where as $key => $value) {
				$where .= "$key = '" . escape_string($value) . "' AND ";
			}
			$where = substr($where, 0, strlen($where) -5);
		
			$query .= " WHERE $where";
		}

		$result = $this->query($query, null);
		
		if (!$result) {
			throw new QueryException($this->_db->get_error());
		}
		
		return true;
	}

	/**
	 * Delete one or more rows.
	 * 
	 * @param string $table_name The table in which to delete.
	 * @param array $where Optional: the where clause of the query in this form: array('field' => $value).
	 * @return boolean true if the deletion is successful, false otherwise.
	 */
	public function delete($table_name, $where = null) {

		//Pre-condition
		if ($where != null && !is_array($where))
			return false;
		
		ksort($where);
		$query = "DELETE FROM $table_name";		
		
		if ($where != null) {
			$whereString = "";
			foreach ($where as $key => $value) {
				$whereString .= "$key = '". escape_string($value) . "' AND ";
			}
			$whereString = substr($whereString, 0, strlen($whereString) -5);
			
			$query .= " WHERE $whereString";
		}
		
		$result = $this->query($query, null);
		
		if (!$result) {
			throw new QueryException($this->_db->get_error());
		}
		
		return true;

	}

}