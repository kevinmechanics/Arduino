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

require_once("../_system/keys.php");
require_once("../_system/db.php");
require_once("../class/Newsfeed.class.php");

$newsfeed_obj = new Newsfeed($mysqli);

$newsfeed_info = $newsfeed_obj->get($id);
if(empty($newsfeed_info)) die("Entry not found");


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
					<h3>Alerts > Edit</h3> <a href="/admin/alerts.php" class="btn btn_small">Back</a>
					<br><br>
					<form method="POST" action="../api/newsfeed/edit.php?id=<?php echo $id; ?>">
						<input type="text" name="title" placeholder="Title" style="width:60%" value="<?php echo $newsfeed_obj['title']; ?>">
						<textarea name="content" placeholder="Content" style="width:60%"><?php echo $newsfeed_obj['content']; ?></textarea>
						<br><br>
						<button type="submit" class="btn">Edit</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>