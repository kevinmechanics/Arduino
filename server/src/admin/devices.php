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
require_once("../class/Device.class.php");

$device = new Device($mysqli);

$dev_list = $device->getAll();

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
					<h3>Devices</h3> <a href="/admin/devices_add.php" class="btn btn_small">Add</a>
					<table>
						<thead>
							<tr>
								<th>Device ID</th>
								<th>Location</th>
								<th>City</th>
								<th>Mobile Number</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach($dev_list as $dev){
								$device_id = $dev['device_id'];
								$location = $dev['location'];
								$city = $dev['city'];
								$mobile_number = $dev['mobile_number'];
								echo "
									<tr>
										<td>$device_id</td>
										<td>$location</td>
										<td>$city</td>
										<td>$mobile_number</td>
										<td>
										<a href='/admin/devices_edit.php?id=$id'>Edit</a>
									</td>
									<td>
										<a style='color:red;' href='/api/device/delete.php?id=$id'>Delete</a>
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