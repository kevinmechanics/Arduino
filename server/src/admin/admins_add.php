<?php
session_start();
//if(empty($_SESSION['loggedin'])) header('Location: login.php');

$AdminObject = $_SESSION['AdminObject'];

$admin_name = "Anonymous";
$admin_username = "username";

if($AdminObject){
	$admin_name = $AdminObject['name'];
	$admin_username = $AdminObject['username'];
}
?>
<!Doctype html>
<html>
	<head>
		<title>Admin - Airduino</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="/admin/styles/style.css">
	</head>
	<body>
		<nav>
			<a class="title" href="#!"><b>Airduino</b> Admin</a>
		</nav>
		<div>
			<div class="row">
				<div class="col s2">
					<h4>Navigation</h4>
					<ul class="collection">
						<li class="collection-item">
							<a href="/admin/index.php">Welcome</a>
						</li>
						<li class="collection-item">
							<a href="/admin/alerts.php">Alerts</a>
						</li>
						<li class="collection-item">
							<a href="/admin/devices.php">Devices</a>
						</li>
						<li class="collection-item">
							<a href="/admin/users.php">Users</a>
						</li>						
						<li class="collection-item">
							<a href="/admin/admins.php">Admins</a>
						</li>
						<li class="collection-item">
							<a href="/admin/account_edit.php">Edit Account</a>
						</li>
						<li class="collection-item">
							<a href="/admin/logout.php">Logout</a>
						</li>
					</ul>
				</div>
				<div class="col s10">
					<h3>Admins > Add</h3> <a href="/admin/admins.php" class="btn btn_small">Back</a>
					<br><br>
					<form method="POST" action="../api/admin/add.php">
						<input type="text" name="name" placeholder="Name" style="width:60%">
						<input type="text" name="username" placeholder="Username" style="width:60%">
						<input type="password" name="password" placeholder="Password" style="width:60%">
						<br><br>
						<button type="submit" class="btn">Add</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
