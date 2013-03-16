<?php

/**
 * This class is a template that help building new model.
 * 
 * @author Michele Stolfa
 * @version 1.1
 */
class Example extends Model {
	
	/*
	 * Define a private variable for each field in the corresponding table
	 * with the same name as the physical field.
	 */
	private $field1;
	private $field2;
	
	public function __construct($conn = false) {
		parent::__construct($conn);
		$this->table_name = "example"; //Database's table name that this class represents
	}
	
	/**
	 * Getter method for each field.
	 * 
	 * @param unknown_type $property Any field.
	 */
	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}
	
	/**
	 * Setter method for each field.
	 * 
	 * @param unknown_type $property Any field.
	 * @param unknown_type $value The new value for that field.
	 * @return The modified field.
	 */
	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}
	
		return $this;
	}
	
	/**
	 * An example method.
	 * 
	 * @return array Data retrieved from database. 
	 */
	public function getExampleData() {
		//Query database using $this->_dao variable
		
		return array(
				'msg' => "example.welcome_text",
				'controller' => IMAGE_PATH . "ExampleController.jpg",
				'model' => IMAGE_PATH . "ExampleModel.jpg",
				'view' => IMAGE_PATH . "ExampleView.jpg"
		);
	}
}