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
		$data_cat = "ALL";
		$d_info = array();
		if(empty($startdate)){
			$t_info = array_reverse($temperature->getByDeviceId($device_id));
			$h_info = array_reverse($humidity->getByDeviceId($device_id));
			$a_info = array_reverse($airquality->getByDeviceId($device_id));
		} else {
			$t_info = $temperature->getAllBetween($device_id,$startdate,$enddate);
			$h_info = $humidity->getAllBetween($device_id,$startdate,$enddate);
			$a_info = $airquality->getAllBetween($device_id,$startdate,$enddate);
		}
		
		foreach($t_info as $t){
			$array = array();
			$timestamp = "";
			$temperature = "";
			$humidity = "";
			$airval = "";
			$airdesc = "";

			$timestamp = $t['timestamp'];
			$temperature = $t['value'];
						
			foreach($h_info as $h){
				$h_t = $h['timestamp'];
				if($h_t == $timestamp) $humidity = $h['value'];
			}
						
			foreach($a_info as $a){
				$a_t = $a['timestamp'];
				if($a_t == $timestamp) $airdesc = $a['description'];
				if($a_t == $timestamp) $airval = $a['value'];
			}
			
			$array = array(
				"timestamp"=>$timestamp,
				"temperature"=>$temperature,
				"humidity"=>$humidity,
				"airdesc"=>$airdesc,
				"airval"=>$airval
			);
			
			$d_info[] = $array;
			
		}
		
		break;
}

$location = $device_info['location'];
$city = $device_info['city'];


/*
PDF Rendering Part
*/

require_once(__DIR__."/_lib/pdf/fpdf.php");
$pdf = new FPDF('P','mm','Letter');

$title = "airduino-$data_cat($location)";

$pdf->SetTitle($title);
$pdf->AddPage();
$pdf->SetMargins(15,20,15);

$pdf->SetFont('Arial','b',25);
$pdf->SetTextColor(25,118,210);
$pdf->Text(90,20,"Airduino");
$pdf->SetFont('Arial','',18);
$pdf->SetTextColor(0,0,0);
$pdf->Text(90,30,"Data Report");

$pdf->SetXY(20,40);

$pdf->SetFont('Arial','',12);
$pdf->Cell(70,7,"Data Category: $data_cat",1,0,'L');
$pdf->Cell(110,7,"Location: $location ($city)",1,0,'L');
$c_y = $pdf->getY();
$pdf->SetXY(20,7+$c_y);
if(empty($startdate)) $startdate = "ALL ENTRIES";
if(empty($enddate)) $enddate = "ALL ENTRIES";
$pdf->Cell(90,7,"Start Date: $startdate",1,0,'L');
$pdf->Cell(90,7,"End Date: $enddate",1,0,'L');

$c_y = $pdf->getY();
$pdf->SetXY(20,15+$c_y);

$pdf->SetFillColor(25,118,210);
$pdf->SetTextColor(255,255,255);

if($data_cat == "ALL"){
	
	$pdf->Cell(50,7,"Timestamp",1,0,'C',"True");
	$pdf->Cell(30,7,"Temp.",1,0,'C',"True");
	$pdf->Cell(30,7,"Humidity",1,0,'C',"True");
	$pdf->Cell(40,7,"AirDesc",1,0,'C',"True");
	$pdf->Cell(30,7,"AirVal",1,0,'C',"True");
	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(255,255,255);
	
	foreach($d_info as $t){
		$c_y = $pdf->getY();
	 $pdf->SetXY(20,7+$c_y);
		
		$timestamp = $t['timestamp'];
		$temperature = $t['temperature'];
		$humidity = $t['humidity'];
		$airdesc = $t['airdesc'];
		$airval = $t['airval'];
		
		$pdf->Cell(50,7,$timestamp,1,0,'L');
		$pdf->Cell(30,7,$temperature,1,0,'L');
		$pdf->Cell(30,7,$humidity,1,0,'L');
		$pdf->Cell(40,7,$airdesc,1,0,'L');
		$pdf->Cell(30,7,$airval,1,0,'L');
		
	}
	
} else {
	if($data_cat == "airquality"){
	
	$pdf->Cell(80,7,"Timestamp",1,0,'C',"True");
	$pdf->Cell(60,7,"Description",1,0,'C',"True");
	$pdf->Cell(40,7,"Value",1,0,'C',"True");

	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(255,255,255);

	foreach($a_info as $a){
	  $c_y = $pdf->getY();
	  $pdf->SetXY(20,7+$c_y);
	
	  $pdf->Cell(80,7,$a['timestamp'],1,0,'L');
	  $pdf->Cell(60,7,$a['description'],1,0,'L');
	  $pdf->Cell(40,7,$a['value'],1,0,'L');
	}
	
} else {
	
	$pdf->Cell(90,7,"Timestamp",1,0,'C',"True");
	$pdf->Cell(90,7,"Value",1,0,'C',"True");
	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(255,255,255);	


	$ar = array();
	switch($data_cat){
	  case('temperature'):
	    $ar = $t_info;
	    break;
	  case('humidity'):
	    $ar = $h_info;
	    break;
	}

	foreach($ar as $a){
	
		$c_y = $pdf->getY();
		$pdf->SetXY(20,7+$c_y);
		
		$pdf->Cell(90,7,$a['timestamp'],1,0,'L');
		$pdf->Cell(90,7,$a['value'],1,0,'L');
		
	}
}
	
}


$pdf->Output('',$title.".pdf",true);
ob_flush();
?>