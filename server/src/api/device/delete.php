<?php

session_start();

if(empty($_SESSION['loggedin'])) die("Unauthorized");

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Device.class.php");

$device = new Device($mysqli);

$id = strip_tags($_GET['id']);

$device->delete($id);

header("Location: ".$_SERVER['HTTP_REFERER']);

?>