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

$newsfeed = new Newsfeed($mysqli);

$nf_list = $newsfeed->getAll();

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
					<h3>Alerts</h3> <a href="/admin/alerts_add.php" class="btn btn_small">Add</a>
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Title</th>
								<th>Content</th>
								<th>Timestamp</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach($nf_list as $nf){
								$id = $nf['id'];
								$title = $nf['title'];
								$content = $nf['content'];
								$timestamp = $nf['timestamp_created'];
								echo "
									<tr>
										<td>$id</td>
										<td>$title</td>
										<td>$content</td>
										<td>$timestamp</td>
										<td></td>
										<td></td>
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
