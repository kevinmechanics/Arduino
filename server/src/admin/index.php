<?php
session_start();
if(empty($_SESSION['loggedin'])) header('Location: /admin/login.php');

@$AdminObject = $_SESSION['AdminObject'];

$admin_name = "Anonymous";
$admin_username = "username";

if(@$AdminObject){
	$admin_name = @$AdminObject['name'];
	$admin_username = @$AdminObject['username'];
}
?>
<!Doctype html>
<html>
	<head>
		<title>Admin - Airduino</title>
		<meta charset="UTF-8">
		<meta name="theme-color" content="#2196F3">
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
					<h3>Welcome, <?php echo $admin_name; ?> (@<?php echo $admin_username;?>)</h3>
						<br><br>
						<img src="/static/splash.png" width="250px">
				</div>
			</div>
		</div>
	</body>
</html>