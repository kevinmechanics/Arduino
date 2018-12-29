<?php

session_start();

if(empty($_SESSION['loggedin'])) die("Unauthorized");

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Admin.class.php");

$admin = new Admin($mysqli);

$name = strip_tags($_POST['name']);
$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);


$array = array(
	"name"=>$name,
	"username"=>$username,
	"password"=>$password
);

$admin->add($array);

header("Location: ".$_SERVER['HTTP_REFERER']);

?>