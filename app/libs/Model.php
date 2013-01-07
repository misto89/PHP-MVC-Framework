<?php

/**
 * This is the basic class for a Model.
 * 
 * @author Michele Stolfa
 * @version 1.1
 * 
 */
class Model {
	
	/**
	 * Table name associated to a subclasses.
	 *
	 * @var string
	 */
	protected $table_name;
	
	/**
	 * An object of DAO class.
	 * 
	 * @var DAO object.
	 */
	protected $_dao;
	
	/**
	 * Initializes the basic model.
	 * 
	 * @param boolean $createConnection Optional: indicates whether to initialize $_dao variable or less. 
	 * If not specified, it is assumed false.
	 */
	public function __construct($createConnection = false) {			
		if ($createConnection)	
			$this->_dao = new DAO(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
			
	}
	
}