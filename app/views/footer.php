
<footer>
	Made by Michele Stolfa
</footer>

<?php 

if (isset($this->_js)) {
	foreach ($this->_js as $js) {
		echo '<script src="' . JS_PATH . $js .'.js"></script>';

	}
}

?>

</body>
</html>
