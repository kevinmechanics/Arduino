<?php

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Humidity.class.php");

$humidity = new Humidity($mysqli);

$device_id = $_REQUEST['device_id'];

$result = $humidity->getLastFifty($device_id);

echo json_encode($result);
?>