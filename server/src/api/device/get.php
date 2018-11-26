<?php

session_start();

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Device.class.php");

$device = new Device($mysqli);

$id = strip_tags($_POST['id']);

$result = $device->get($id);

echo json_encode($result);

?>
