<?php

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/AirQuality.class.php");

$air_quality = new AirQuality($mysqli);

$device_id = $_REQUEST['device_id'];

$result = $air_quality->getLastFifty($device_id);

echo json_encode($result);
?>