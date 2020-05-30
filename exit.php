<?php
include 'helper.php';

if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'admin') {
	unset($_SESSION['auth']);
	header("location: index.php");
}

?>