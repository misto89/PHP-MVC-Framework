<!DOCTYPE html>
<html>
<head>
<title></title>

<?php

if (isset($this->_css)) {
	foreach ($this->_css as $css) {
		echo '<link rel="stylesheet" type="text/css" href="'. CSS_PATH . $css. '.css" />';

	}
}

?>

</head>

<body>
	<a href="<?php echo URL . 'local/change/it_IT/?request=' . $_SERVER['REQUEST_URI'] ?>">ITA</a> <!-- Change local language in Italian -->
	<a href="<?php echo URL . 'local/change/en_EN/?request=' . $_SERVER['REQUEST_URI'] ?>">ENG</a> <!-- Change local language in English -->
	
	<br><br>
	
	<div>PHP - MVC Framework v1.2</div>