<?php

/**
 * This class is used to handle HTTP request. Require Apache's mod_rewrite.
 * Requests must be expressed in the format "controllerName/methodName/optionalParameters".
 * 
 * @author Michele Stolfa
 * @version 1.1
 */
class Bootstrap {
	
	/**
	 * The requested url in array form.
	 * 
	 * @var array
	 */
	private $url;
	
	/**
	 * The instantiated controller.
	 * 
	 * @var Controller subclass
	 */
	private $controller;
	
	/**
	 * For each request, an object of this class determines and instantiates 
 	 * the controller can handle it, and then invokes a method of this controller.
 	 * If controller or method not exists, an error page is displayed. 
 	 * If request doesn't specify any controller, an IndexController is instantiated and the method index() is invoked. 
 	 * In this case, the application's index page is displayed to the user.
	 */
	public function __construct() {
		
		$this->getUrl();
		
		//No controller is specified.
		if (empty($this->url[0])) {
			$this->loadDefaultController();
			return;
		}

		$this->loadCurrentController();
		$this->callControllerMethod();

	}

	/**
	 * Invoke the requested method.
	 */
	private function callControllerMethod() {
		try {
			
			if (isset($this->url[1])) {
				if (method_exists($this->controller, $this->url[1])) {
						
					$parameters = array();
					for ($i = 2; $i < count($this->url); $i++)
						array_push($parameters, $this->url[$i]);
							
					$countParam = count($parameters);
					
					if ($countParam == 0)
						$this->controller->{$this->url[1]}();
					else if ($countParam == 1)
						$this->controller->{$this->url[1]}($parameters[0]);
					else
						$this->controller->{$this->url[1]}($parameters);
						
				} else { //Method not found.
					$this->error();
				}
			
			} else { //No method is specified.
				$this->controller->index(); 
			}
					
		} catch (QueryException $e) {
			$this->error($e->getMessage() . " ( " . $e->getFile() . ": line  " . $e->getLine() . ")");
			
		} catch (Exception $e) {
			$msg = $e->getMessage();
			if ($msg == "")
				$msg = "An error occuring during execution";
			
			$this->error($msg . " ( " . $e->getFile() . ": line  " . $e->getLine() . ")");
		}
	}
	
	/**
	 * Load the requested controller.
	 */
	private function loadCurrentController() {
		$controller_name = ucfirst($this->url[0]) . CONTROLLER_SUFFIX;
		$controller_path = CONTROLLERS_PATH . $controller_name . '.php';
		
		if (file_exists($controller_path)) {
			require $controller_path;
		} else { //Controller not found.
			$this->error(); 
		}
		
		try {
			$this->controller = new $controller_name;
		} catch (Exception $e) { //Any error.
			$msg = $e->getMessage();
			if ($msg == "")
				$msg = "An error occuring during execution";
			
			$this->error($msg . " ( " . $e->getFile() . ": line  " . $e->getLine() . ")");
		}
	}
	
	/**
	 * Load an IndexController showing the index page to the user.
	 */
	private function loadDefaultController() {
		require CONTROLLERS_PATH . 'IndexController.php';
		
		try {
			$controller = new IndexController();
			
		} catch (Exception $e) { //Any error.
			$msg = $e->getMessage();
			if ($msg == "")
				$msg = "An error occuring during execution";
			
			$this->error($msg . " ( " . $e->getFile() . ": line  " . $e->getLine() . ")");
		}
		
		try {
			$controller->index();
			
		} catch (QueryException $e) {
			$this->error($e->getMessage() . " ( " . $e->getFile() . ": line  " . $e->getLine() . ")");
				
		} catch (Exception $e) {
			$msg = $e->getMessage();
			if ($msg == "")
				$msg = "An error occuring during execution";
				
			$this->error($msg . " ( " . $e->getFile() . ": line  " . $e->getLine() . ")");
		}
	}
	
	/**
	 * Initializes $this->url array.
	 */
	private function getUrl() {
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$this->url = explode('/', $url);
	}
	
	/**
	 * Show the error page, with an error message.
	 * 
	 * @param string $msg The error message to be displayed.
	 */
	private function error($msg = null) {
		require CONTROLLERS_PATH . 'ErrorController.php';
		$controller = new ErrorController();
		if ($msg == null)
			$msg = "Error 404: The requested page not exists";
		
		$controller->index(base64_encode($msg));
	}

}