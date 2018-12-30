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

if(empty($_GET['device_id'])) die("Device ID is Required");
$device_id = strip_tags($_GET['device_id']);

require_once("../_system/keys.php");
require_once("../_system/db.php");
require_once("../class/Device.class.php");
require_once("../class/Temperature.class.php");

$device = new Device($mysqli);
$temperature = new Temperature($mysqli);

$device_info = $device->getByDeviceId($device_id);
if(empty($device_info)) die("Device not found");

$temp_list = $temperature->getByDeviceId($device_id);


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
					<h3>Temperature for <?php echo $device_info['location'] . " - " . $device_info['city']; ?></h3>  <a href="/admin/devices.php" class="btn btn_small">Back</a>
					<table>
						<thead>
							<tr>
								<th>Value</th>
								<th>Timestamp</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach($temp_list as $t){
								$id = $t['id'];
								$value = $t['value'];
								$timestamp = $t['timestamp'];

								echo "
								<tr>
									<td>$value</td>
									<td>$timestamp</td>
									<td>
										<a style='color:red;' href='/api/temperature/delete.php?id=$id'>Delete</a>
									</td>
								</tr>
								";
							}	
						?>
						</tbody>
					</table>					
				</div>
			</div>
		</div>
	</body>
</html>