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
require_once("../class/Device.class.php");

$device_obj = new Device($mysqli);

$device_info = $device_obj->get($id);
if(empty($device_info)) die("Device not found");

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
					<h3>Devices > Edit</h3> <a href="/admin/devices.php" class="btn btn_small">Back</a>
					<br><br>
					<form method="POST" action="../api/device/edit.php?id=<?php echo $id; ?>">
						<input type="text" name="device_id" placeholder="Device ID" style="width:60%" value="<?php echo $device_info['device_id']; ?>">
						<input type="text" name="location" placeholder="Location" style="width:60%" value="<?php echo $device_info['location']; ?>">
						<input type="text" name="city" placeholder="City" style="width:60%" value="<?php echo $device_info['city']; ?>">
						<input type="text" name="mobile_number" placeholder="Mobile Number" style="width:60%" value="<?php echo $device_info['mobile_number']; ?>">
						<br><br>
						<button type="submit" class="btn">Edit</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>