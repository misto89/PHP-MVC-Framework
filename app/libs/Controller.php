<?php

/**
 * This is the basic class for a Controller.
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class Controller {
	
	/**
	 * The View object.
	 * 
	 * @var object
	 */
	protected $_view;
	
	/**
	 * The model object.
	 * 
	 * @var object
	 */
	protected $_model;

	/**
	 * Initialize the basic Controller.
	 */
	function __construct() {
		$this->_view = new View();
	}
	
}