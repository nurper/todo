<?php
include 'helper.php';
if (isset($_POST)){
	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = clean_input($username);
	$password = clean_input($password);

	$response = mysqli_query($conn, "SELECT * FROM users where username = '$username' and password = '$password'");
	$row = mysqli_fetch_array($response);

	if ($row['username'] == $username && $row['password'] == $password) {
		$_SESSION['auth'] = 'admin';
		header("location: index.php");
	}else{
		$_SESSION['auth'] = 'error';
		header("location: login.php");
	}
}

?>