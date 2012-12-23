<?php

/**
 * This class is used to manage HTTP request. Require Apache's mod_rewrite.
 * Requests must be expressed in the format "controllerName/methodName/optionalParameter".
 * 
 * @author Michele Stolfa
 * @version 1.0
 */
class Bootstrap {
	
	/**
	 * For each request, an object of this class determines and instantiates 
 	 * the controller can handle it, and then invokes a method of this controller.
 	 * If controller or method not exists, it show an error page. 
 	 * If request doesn't specify any controller, an IndexController is instantiated and the method index() is invoked. 
 	 * In this case, the application's index page is shown to the user.
	 */
	function __construct() {

		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);

		
		if (empty($url[0])) {
			require CONTROLLER_PATH . 'IndexController.php';
			$controller = new IndexController();
			$controller->index();
			return false;
		}

		$controller_name = ucfirst($url[0]) . CONTROLLER_SUFFIX;
		//build to the controller file reference
		$controller_path = CONTROLLER_PATH . $controller_name . '.php';

		if (file_exists($controller_path)) {
			require $controller_path;
		} else {
			return $this->error();
		}

		try {
			$controller = new $controller_name;
		} catch (Exception $e) {
			$this->error($e->getMessage());
		}

		try {
			// calling methods
			if (isset($url[2])) {
				if (method_exists($controller, $url[1])) {
					$controller->{$url[1]}($url[2]);
				} else {
					$this->error();
				}
				
			} else {
				if (isset($url[1])) {
					if (method_exists($controller, $url[1])) {
						$controller->{$url[1]}();
					} else {
						$this->error();
					}
					
				} else {
					$controller->index();
				}
			}
		} catch (QueryException $e) {
			$this->error($e->getMessage());
		}

	}

	/**
	 * Show the error page, with an error message.
	 * 
	 * @param string $msg The error message to be displayed.
	 */
	private function error($msg = null) {
		require CONTROLLER_PATH . 'ErrorController.php';
		$controller = new ErrorController();
		if ($msg == null)
			$msg = "404 Page not found";
		
		$controller->index(base64_encode($msg));
	}

}