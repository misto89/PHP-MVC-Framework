<?php

/**
 * This class represents a view, and it is used to make any view.
 * 
 * @author Michele Stolfa
 * @version 1.1
 */
class View {
	
	/**
	 * An object of Translator class.
	 * 
	 * @var Translator The current translator
	 */
	private $_translator;

	/**
	 * Contains the javascript files needed for all views.
	 * 
	 * @var array The javascript files.
	 */
	private $_js;
	
	/**
	 * Contains the css files needed for all views.
	 * 
	 * @var array The css files.
	 */
	private $_css;
	
	/**
	 * View constructor. Initializes javascript and css files for all views, and the translator for strings.
	 */
	public function __construct() {
		$this->_translator = new Translator(Session::get('local'));
		$this->_js = array();
		$this->_css = array();
	}
	
	/**
	 * Add one or more javascript files for the current view.
	 * 
	 * @param array $js Array of javascript files.
	 */
	public function addJsFiles($js) {
		$this->_js = array_merge($this->_js, $js);
	}
	
	/**
	 * Add one or more css files for the current view.
	 * 
	 * @param array $css Array of css files.
	 */
	public function addCssFiles($css) {
		$this->_css = array_merge($this->_css, $css);
	}
	
	/**
	 * Show a single html page to the user.
	 * 
	 * @param string $name The view to render, for example index/index.
	 * @param mixed $data Optional data that the view must show in the template.
	 */
	public function render($name, $data = null) {
		require VIEWS_PATH. 'header.php';
		require VIEWS_PATH . $name . '.php';
		require VIEWS_PATH . 'footer.php';

	}
}