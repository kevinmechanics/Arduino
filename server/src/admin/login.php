<?php
session_start();

$msg = "";

if(!empty($_POST['username'])){
	$username = $_POST['username'];
	$password = $_POST['password'];	
	
	require_once("../_system/keys.php");
	require_once('../_system/db.php');
	require_once('../class/Admin.class.php');
	
	$admin = new Admin($mysqli);
	
	$array = Array(
		"username"=>$username,
		"password"=>$password
	);
	
	$result = $admin->verifyCredentials($array);
	
	if($result == True){
	
		$_SESSION["loggedin"] = True;
		$_SESSION["AdminObject"] = $admin->getByUsername($username);
		
		header("Location: index.php");
		
	} else {
		$msg = "Invalid credentials";
	}
}

?>
<!Doctype html>
<html>
	<head>
		<title>Admin - Airduino</title>
		<meta name="theme-color" content="#2196F3">
		<link rel="stylesheet" href="/admin/styles/style.css">
	</head>
	<body>
		<div class="container">
			<h1><center style="color:#2196F3;">Airduino Admin</center></h1>
			<p><?php if($msg) echo $msg; ?></p>
			<form method="POST">
				<input type="text" name="username" placeholder="Username" style="width:100%; margin-bottom:15px;"><br>
				<input type="password" name="password" placeholder="Password" style="width:100%;"><br>
				<br>
				<button type="submit" class="btn">Login</button>
			</form>
		</div>
	</body>
</html>