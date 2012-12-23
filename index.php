<?php

require_once 'config.php';

function __autoload($class) {
	if (file_exists(LIBS . $class .".php"))
		require_once LIBS . $class .".php";
	else if (file_exists(MODELS .$class. ".php"))
		require_once MODELS . $class .".php";
}

$app = new Bootstrap();


