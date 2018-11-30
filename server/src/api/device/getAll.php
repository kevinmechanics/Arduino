<?php

session_start();

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Device.class.php");

$device = new Device($mysqli);


$result = $device->getAll();

echo json_encode($result);

?>
