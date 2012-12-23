<!DOCTYPE html>
<html>
<head>
<title></title>

<?php
if (isset($this->_js)) {
	foreach ($this->_js as $js) {
		echo '<script src="' . JS_PATH . $js .'.js"></script>';

	}
}

if (isset($this->_css)) {
	foreach ($this->_css as $css) {
		echo '<link rel="stylesheet" type="text/css" href="'. CSS_PATH . $css. '.css" />';

	}
}
?>

</head>

<body>
	<?php Session::init();?>

	<div class="container">

		<!-- Masthead================================================== -->
		<header class="jumbotron masthead">
			<div class="inner">PHP - MVC Framework v1.0</div>

			<!-- <div class="bs-links"></div> -->
		</header><br>