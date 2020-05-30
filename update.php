<?php
include 'helper.php';

if (isset($_POST['id'])) {
	if (isset($_POST['isDone'])) {
		mysqli_query($conn,"UPDATE tasks SET isDone=1 WHERE id='$_POST[id]'");
		header("location: index.php");
	}
	if (isset($_POST['content'])) {
		$content = $_POST['content'];
		mysqli_query($conn,"UPDATE tasks SET isDone=1, isEdited=1, content='$content'
		WHERE id='$_POST[id]'");
		header("location: index.php");
	}
}
?>