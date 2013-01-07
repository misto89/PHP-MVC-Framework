<?php

/*
 * This is the Front Controller.
 */

require_once 'config.php';

function __autoload($class) {
	if (file_exists(LIBS_PATH . $class .".php"))
		require_once LIBS_PATH . $class .".php";
	else if (file_exists(MODELS_PATH .$class. ".php"))
		require_once MODELS_PATH . $class .".php";
}

new Bootstrap();


