<?php

// Always provide a TRAILING SLASH (/) AFTER A PATH
define('URL', '/PHP-MVC-Framework/');
define('CONTROLLER_SUFFIX','Controller');
define('LIBS_PATH', 'app/libs/');
define('MODELS_PATH','app/models/');
define('CONTROLLERS_PATH', 'app/controllers/');
define('VIEWS_PATH', 'app/views/');
define('IMAGE_PATH', URL . 'assets/img/');
define('ICON_PATH', URL . 'assets/ico/');
define('CSS_PATH', URL . 'assets/css/');
define('JS_PATH', URL . 'assets/js/');

define('DB_TYPE', '');
define('DB_HOST', '');
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASS', '');

// The sitewide hashkey, do not change this because its used for passwords!
// This is for other hash keys... Not sure yet
define('HASH_GENERAL_KEY', 'toomuchwork'); //DON'T CHANGE OR DELETE IT

// This is for database passwords only
define('HASH_PASSWORD_KEY', 'toomuchworkwillkillyou'); //DON'T CHANGE OR DELETE IT

define('DOUBLE_QUOTE', "''");
define('SINGLE_QUOTE', "'");

define('DOUBLE_SLASH', "\\\\");
define('SINGLE_SLASH', "\\");

/**
 * Push a new "$key => $value" in an existing associative array.
 * 
 * @param array $assoc_array the associative array
 * @param unknown_type $key the new key
 * @param unknown_type $value the new value
 */
function array_push_assoc(&$assoc_array, $key, $value) {
	$keys = array_keys($assoc_array);
	$values = array_values($assoc_array);
	array_push($keys, $key);
	array_push($values, $value);
	$assoc_array = array_combine($keys, $values);
}

/**
 * Allows to store a string contains a quote or a backslash, no both.
 * 
 * @param string $string a string
 * @return the escaped string
 */
function escape_string($string) {
	$string = str_replace(SINGLE_QUOTE, DOUBLE_QUOTE, $string);
	return str_replace(SINGLE_SLASH, DOUBLE_SLASH, $string);
}