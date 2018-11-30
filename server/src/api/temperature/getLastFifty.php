<?php

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Temperature.class.php");

$temperature = new Temperature($mysqli);

$device_id = $_REQUEST['device_id'];

$result = $temperature->getLastFifty($device_id);

echo json_encode($result);
?>