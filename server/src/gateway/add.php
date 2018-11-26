<?php
/*
Airduino sample request:
http://localhost/gateway/add.php?device_id=1&temperature=30&air_value=34&air_description=Moderate&humidity=40
*/

require_once("../_system/keys.php");
require_once("../_system/db.php");
require_once("../class/Temperature.class.php");
require_once("../class/Humidity.class.php");
require_once("../class/AirQuality.class.php");

if(empty($_GET['device_id'])) die();

$device_id = strip_tags($_GET['device_id']);
$temperature_val = strip_tags($_GET['temperature']);
$air_value = strip_tags($_GET['air_value']);
$air_description = strip_tags('air_description');
$humidity_val = strip_tags('humidity');

$temperature = new Temperature($mysqli);
$air_quality = new AirQuality($mysqli);
$humidity = new Humidity($mysqli);

$array_temp = array(
	"device_id"=>$device_id,
	"value"=>$temperature_val
);

$array_air = array(
	"device_id"=>$device_id,
	"value"=>$air_value,
	"description"=>$air_description
);

$array_humidity = array(
	"device_id"=>$device_id,
	"value"=>$humidity_val
);

$temperature->add($array_temp);
$air_quality->add($array_air);
$humidity->add($array_humidity);

echo "OK";

?>
