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

$id = $_GET['id'];

require_once("../_system/keys.php");
require_once("../_system/db.php");
require_once("../class/Admin.class.php");

$admin_obj = new Admin($mysqli);

$admin_info = $admin_obj->get($id);
if(empty($admin_info)) die("Admin not found");

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
					<h3>Admins > Edit</h3> <a href="/admin/admins.php" class="btn btn_small">Back</a>
					<br><br>
					<form method="POST" action="../api/admin/edit.php?id=<?php echo $id; ?>">
						<input type="text" name="name" placeholder="Name" style="width:60%" value="<?php echo $admin_obj['name']; ?>">
						<input type="text" name="username" placeholder="Username" style="width:60%" value="<?php echo $admin_obj['username']; ?>">
						<input type="password" name="password" placeholder="Password" style="width:60%">
						<br><br>
						<button type="submit" class="btn">Edit</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>