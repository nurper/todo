<?php
include 'helper.php';
if (isset($_POST)) {
	$name = clean_input($_POST["name"]);
	$email = clean_input($_POST["email"]);
	$text = clean_input($_POST["text"]);

	mysqli_query($conn, "INSERT INTO tasks (username, email, content)
	 VALUES ('$name', '$email', '$text')");
	$_SESSION['success'] = 'true';
	header('location: index.php');
}
?>