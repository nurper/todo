<?php
include 'helper.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
	<?php
		if (isset($_SESSION['auth']) && $_SESSION['auth']=='error') {
			echo '<p style="color: red; font-size: 25">Неправильный логин или пароль</p>';
			unset($_SESSION['auth']);
		}
	?>
	<div class="container">
		<div class="h3 col text-center">To Do List</div>
		<div class="card p-4 mx-auto mt-4" style="width: 300px;">
			<form action="auth.php" method="POST">
				<div class="form-group">
					<input type="text" placeholder="Login" class="form-control" name="username" required>
				</div>
				<div class="form-group">
					<input type="password" placeholder="Password" class="form-control" name="password" required>
				</div>
				<button type="submit" class="btn btn-block btn-primary">Войти</button>
			</form>
		</div>
	</div>
</body>
</html>