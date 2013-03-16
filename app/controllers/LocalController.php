<?php

/**
 * This class is used to change the local language. 
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class LocalController extends Controller {
	
	/**
	 * Construct a LocalController
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Change the local language.
	 * 
	 * @param string $newLocal New local language, for example it_IT or en_EN
	 */
	public function change($newLocal) {
		Session::set('local', $newLocal);
		header("Location: " . $_GET['request']);
	}
}