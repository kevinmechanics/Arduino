<?php

session_start();

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Device.class.php");

$device = new Device($mysqli);

$device_id = strip_tags($_POST['device_id']);
$location = strip_tags($_POST['location']);
$city = strip_tags($_POST['city']);
$mobile_number = strip_tags($_POST['mobile_number']);

$array = array(
	"device_id"=>$device_id,
	"location"=>$location,
	"city"=>$city,
	"mobile_number"=>$mobile_number
);

$device->add($array);

header("Location: ".$_SERVER['HTTP_REFERER']);

?>
