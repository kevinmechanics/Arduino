<?php
ob_start();
$data_cat = "";
$device_id = "";
$startdate = "";
$enddate = "";

if(!empty($_GET['data_cat'])) $data_cat = strip_tags($_GET['data_cat']);
if(!empty($_GET['device_id'])) $device_id = strip_tags($_GET['device_id']);
if(!empty($_GET['startdate'])) $startdate = str_ireplace("T"," ",strip_tags($_GET['startdate']));
if(!empty($_GET['enddate'])) $enddate = str_ireplace("T"," ",strip_tags($_GET['enddate']));

require_once("../_system/keys.php");
require_once("../_system/db.php");
require_once("../class/Device.class.php");
require_once("../class/Temperature.class.php");
require_once("../class/Humidity.class.php");
require_once("../class/AirQuality.class.php");

$device = new Device($mysqli);
$temperature = new Temperature($mysqli);
$humidity = new Humidity($mysqli);
$airquality = new AirQuality($mysqli);

$device_info = $device->getByDeviceId($device_id);

$t_info = array();
$h_info = array();
$a_info = array();

switch($data_cat){
	case('temperature'):
		if(empty($startdate)){
		  $t_info = array_reverse($temperature->getByDeviceId($device_id));
		} else {
		  $t_info = $temperature->getAllBetween($device_id,$startdate,$enddate);
		}
    		break;
	case('humidity'):
		if(empty($startdate)){
		  $h_info = array_reverse($humidity->getByDeviceId($device_id));
		} else {
		  $h_info = $humidity->getAllBetween($device_id,$startdate,$enddate);
		}
    		break;
	case('airquality'):
		if(empty($startdate)){
		  $a_info = array_reverse($airquality->getByDeviceId($device_id));
		} else {
		  $a_info = $airquality->getAllBetween($device_id,$startdate,$enddate);
		}
      		break;
	default:
		$a = 1;
		break;
}

$location = $device_info['location'];
$city = $device_info['city'];


require_once(__DIR__."/_lib/xlsx/xlsxwriter.class.php");
$title = "airduino-$data_cat($location)";

$writer = new XLSXWriter();
if(empty($data_cat)) $data_cat = "temperature";

switch($data_cat){
	case('temperature'):
		$writer->writeSheetHeader($data_cat,array(
			"id"=>"string",
			"device_id"=>"string",
			"value"=>"string",
			"timestamp"=>"string"
		));
		
		foreach($t_info as $a){
			$writer->writeSheetRow($data_cat,$a);
		}
		
		break;
	case('humidity'):
		$writer->writeSheetHeader($data_cat,array(
			"id"=>"string",
			"device_id"=>"string",
			"value"=>"string",
			"timestamp"=>"string"
		));
		foreach($h_info as $a){
			$writer->writeSheetRow($data_cat,$a);
		}
		break;
	case('airquality'):
		$writer->writeSheetHeader($data_cat,array(
			"id"=>"string",
			"device_id"=>"string",
			"value"=>"string",
			"description"=>"string",
			"timestamp"=>"string"
		));
		foreach($a_info as $a){
			$writer->writeSheetRow($data_cat,$a);
		}
		break;
	default:
		$writer->writeSheetHeader($data_cat,array(
			"timestamp"=>"string",
			"value"=>"string"
		));
		break;
}

$filename = "$data_cat-$location.xlsx";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename");
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Origin: *');
// Output File
echo $writer->writeToString();


ob_flush();
?>