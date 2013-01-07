<?php

/**
 * This class is used to render a general error page.
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class ErrorController extends Controller {
	
	/**
	 * Construct an ErrorController
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Render the error page, and shows an error message to the user.
	 * 
	 * @param string $errorMessage The error message, encrypted using base64_encode() php function.
	 */
	public function index($errorMessage) {
		$this->_view->render('error/index', base64_decode($errorMessage));
	}
}