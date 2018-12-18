<?php
session_start();
//if(empty($_SESSION['loggedin'])) header('Location: login.php');

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
		<title>Airduino</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="/admin/styles/style.css">
	</head>
	<body>
		<nav>
			<a class="title" href="#!"><b>Airduino</b></a>
		</nav>
		<br><br>
		<div style="margin: 0 auto; max-width: 1280px; width: 90%; ">
			<div class="row">
				<div class="col s4">
					<img src="/static/screenshot.png" style="width:250px; box-shadow: 0 20px 40px rgba(150, 150, 150, 0.3);">
				</div>
				<div class="col s8">
					<h2>Get the temperature, humidity and air quality in your baranggay.</h2>
					<h4>Anytime, anywhere.</h4>
					<br><br>
					<a href="#!">
						<img src="/static/google-play-badge.png" width="250px">
					</a>
					<p style="font-size:10pt;">Google Play and the Google Play logo are trademarks of Google LLC.</p>
				</div>
			</div>
		</div>
	</body>
</html>
