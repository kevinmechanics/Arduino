<?php
/*
Airduino sample request:
https://airduino-ph.000webhostapp.com/gateway/add.php? device_id=1&temperature=30&air_value=34&air_description=Moderate&humidity=40 
*/

require_once("../_system/keys.php");
require_once("../_system/db.php");
require_once("../class/Temperature.class.php");
require_once("../class/Humidity.class.php");
require_once("../class/AirQuality.class.php");
require_once("../class/Device.class.php");

header("Content-Type: application/json");

function throwError($message){
	header("HTTP/1.1 400 $message");
	if(empty($message)) $message = "An Unknown Error Occurred";
	$array = array(
		"code"=>401,
		"message"=>$message
	);
	echo json_encode($array);	
}

if(empty($_GET['device_id'])){
	throwError("Device ID is Required");
	die();
} 

try {
	$device_id = strip_tags($_GET['device_id']);
	$temperature_val = strip_tags($_GET['temperature']);
	$air_value = strip_tags($_GET['air_value']);
	$air_description = strip_tags($_GET['air_description']);
	$humidity_val = strip_tags($_GET['humidity']);

	$device = new Device($mysqli);
	$temperature = new Temperature($mysqli);
	$air_quality = new AirQuality($mysqli);
	$humidity = new Humidity($mysqli);
	
	if(empty($device->getByDeviceId($device_id))){
		throwError("Unauthorized and Unknown Device");
		die();
	}
			
} catch(Exception $e){
	throwError("An argument might be missing");
	die();
}

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


try {
	
	$temperature->add($array_temp);
	$air_quality->add($array_air);
	$humidity->add($array_humidity);
		
		
	header("HTTP/1.1 200 Successfully Added Data");
	$array = array(
		"code"=>"200",
		"message"=>"OK"
	);
	
		
} catch(Exception $e){
	
	throwError("Error occurred while adding the data");
	die();
	
}

?>