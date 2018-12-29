<?php

session_start();

if(empty($_SESSION['loggedin'])) die("Unauthorized");

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Admin.class.php");

$admin = new Admin($mysqli);

$id = strip_tags($_REQUEST['id']);
$name = strip_tags($_POST['name']);
$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);


$array = array(
	"id"=>$id,
	"name"=>$name,
	"username"=>$username,
	"password"=>$password
);

$admin->update($array);

header("Location: ".$_SERVER['HTTP_REFERER']);

?>