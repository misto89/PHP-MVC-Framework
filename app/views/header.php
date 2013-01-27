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
	
	<div>PHP - MVC Framework v1.1</div>
