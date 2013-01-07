<?php
/**
 * This class is used to manage exceptions derived by an error in a query.
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class QueryException extends Exception {
	
	/**
	 * Throw a new QueryException
	 * 
	 * @param string $message The exception message
	 */
	public function __construct($message) {
		parent::__construct($message);
	}
}