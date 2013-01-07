<?php

/**
 * This class is used to render the application index page.
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class IndexController extends Controller {

	/**
	 * Construct an IndexController
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Show the index page.
	 */
	public function index() {
		$this->_view->render('index/index');
	}
		
}