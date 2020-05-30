<?php
include 'helper.php';
$successSubmit = "";
if (isset($_SESSION['success']) && $_SESSION['success']=='true'){
	$successSubmit = "Добавлено";
	unset($_SESSION['success']);
}

$dir = isset($_GET['dir']) ? $_GET['dir'] : "ASC";

$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'username';
if(strcmp($sortBy, 'status')==0)
	$orderBy = 'isDone, isEdited';
else
	$orderBy = $sortBy;

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * 3;

$response = mysqli_query($conn, "SELECT * FROM tasks ORDER BY $orderBy $dir LIMIT $start, 3");
$nextDir = $dir == "ASC" ? "DESC" : "ASC";

$response1 = mysqli_query($conn, "SELECT count(id) as id FROM tasks");
$tasksCount = mysqli_fetch_all($response1)[0][0];
$pages = ceil($tasksCount / 3);


?>


<!DOCTYPE html>
<html>
<head>
	<title>TO DO App</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
  		<a class="navbar-brand" href="#">TO DO List</a>
  		<button class="btn btn-outline-success" type="submit"><a href="login.php">Авторизация</a></button>
  		<?php if ($_SESSION['auth'] == 'admin') {
  			echo '<button class="btn btn-outline-success" type="submit"><a href="exit.php">Выйти</a></button>';
  		} ?>
	</nav>
	<div class="container mt-3">
	<p style="color: green; font-size: 25"><?=$successSubmit?></p>
	<form method="post" action="submitTask.php">
		<div class="form-row">
			<div class="form-group col-md-6">
				<input class="form-control" type="text" name="name" placeholder="Имя пользователя" required>
			</div>
			<div class="form-group col-md-6">
				<input class="form-control" type="email" name="email" placeholder="e-mail" required>
			</div>
		</div>
		<div class="form-group">
	    	<input name="text" type="text" class="form-control" id="inputAddress" placeholder="Текст задачи" required>
		 </div>
		<button type="submit" name="submit" class="btn btn-primary">Добавить</button>
	</form>
	<div class="container mt-3">
		<table class="table">
			<thead>
				<tr>
					<th scope="col">
						<a href="index.php?sortBy=username&dir=<?= $nextDir?>">Имя пользователя</a>
					</th>
					<th scope="col">
						<a href="index.php?sortBy=email&dir=<?= $nextDir?>">e-mail</a>
					</th>
					<th scope="col">
						Текст задачи
					</th>
					<th scope="col">
						<a href="index.php?sortBy=status&dir=<?= $nextDir?>">Статус</a>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php while( $task = mysqli_fetch_array($response) ) { ?>
					<tr>
						<form action='update.php' method='POST'>
							<input type='hidden' name='id' value=<?=$task['id']?>>
							<td>
								<?php echo $task["username"]; ?>
							</td>
							<td>
								<?php echo $task["email"]; ?>
							</td>
							<td>
								<?php if ($_SESSION['auth'] == 'admin') {
									echo "<input type='text' name='content' value=" . $task['content'] .">";
								} else
									echo $task["content"]; ?>
							</td>
							<td>
								<?php $status = $task["isDone"] ? "выполнено" : "не выполнено";
								echo $task["isEdited"] ? $status . "/отредактировано администратором" : $status; ?>
							</td>
							<?php
							if ($_SESSION['auth'] == 'admin') {
								echo "<td>" . 
										"<button class='btn btn-primary' type='submit'>Изменить</button>".
									"</td>";
								echo "";
							}
							?>
						</form>
						<?php
						if ($_SESSION['auth'] == 'admin' && $task['isDone'] == 0) {
							echo "<td>" .
									"<form action='update.php' method='POST'>" .
										"<input type='hidden' name='id' value=" . $task['id'] . ">" .
										"<input class='btn btn-primary' type='submit' name='isDone' value='Выполнено'>" .
									"</form>" .
								"</td>";
						}
						?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<ul class="nav">
			<?php for ($i=1; $i <= $pages; $i++) : ?>
				<li class="nav-item">
					<a class="nav-link active" href="index.php?page=<?= $i; ?>&sortBy=<?= $sortBy; ?>&dir=<?= $dir?>"><?= $i; ?></a>
				</li>
			<?php endfor ?>
		</ul>	
	</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>