<?php

/**
 * This class is a template that help building new controller.
 *
 * @author Michele Stolfa
 * @version 1.0
 */
class ExampleController extends Controller {

	/**
	 * Construct a new controller.
	 */
	public function __construct() {
		parent::__construct();
		
		//Not necessary if there isn't a corresponding model.
		$this->_model = new Example(false); //It must be always true. CHANGE IT IN true.
	}

	/**
	 * Show the index page of this controller.
	 */
	public function index() {
		$data = $this->_model->getExampleData();
		$this->_view->render('example/index', $data);
	}

}