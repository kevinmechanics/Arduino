<?php
session_start();

if(empty($_SESSION['loggedin'])) die("Unauthorized");

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/User.class.php");

$user = new User($mysqli);

$id = strip_tags($_GET['id']);
$first_name = strip_tags($_POST['first_name']);
$last_name = strip_tags($_POST['last_name']);
$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);
$email = strip_tags($_POST['email']);

$array = array(
				 "id"=>$id,
    "first_name"=>$first_name,
    "last_name"=>$last_name,
    "username"=>$username,
    "password"=>$password,
    "email"=>$email
);

$result = $user->update($array);

header("Location: " . $_SERVER['HTTP_REFERER']);
?>