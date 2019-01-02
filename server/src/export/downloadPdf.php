<?php
/*
$data_cat = "";
$device_id = "";
$startdate = "";
$enddate = "";

if(!empty($_GET['data_cat'])) $data_cat = strip_tags($_GET['data_cat']);
if(!empty($_GET['device_id'])) $device_id = strip_tags($_GET['device_id']);
if(!empty($_GET['startdate'])) $startdate = strip_tags($_GET['startdate']);
if(!empty($_GET['enddate'])) $enddate = strip_tags($_GET['enddate']);

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
		$t_info = $temperature->getByDeviceId($device_id);
		break;
	case('humidity'):
		$h_info = $humidity->getByDeviceId($device_id);
		break;
	case('airquality'):
		$a_info = $airquality->getyDeviceId($device_id);
		break;
	default:
		die();
		break;
}
*/
/*
PDF Rendering Part
*/

require_once(__DIR__."/_lib/pdf/fpdf.php");
$pdf = new FPDF('P','mm','Letter');

$dev_loc = $data_info['location'];
$title = "airduino-$data_cat($dev_loc)";

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
$pdf->Cell(70,7,"Data Category: Temperature",1,0,'L');
$pdf->Cell(110,7,"Location: Brgy. Sta Cruz (Example City)",1,0,'L');
$c_y = $pdf->getY();
$pdf->SetXY(20,7+$c_y);
$pdf->Cell(90,7,"Start Date: 12/12/2019 10:00:00",1,0,'L');
$pdf->Cell(90,7,"End Date: 12/12/2019 10:00:00",1,0,'L');

$c_y = $pdf->getY();
$pdf->SetXY(20,15+$c_y);

$pdf->SetFillColor(25,118,210);
$pdf->SetTextColor(255,255,255);
if($data_cat == "airquality"){
	
	$pdf->Cell(80,7,"Timestamp",1,0,'C',"True");
	$pdf->Cell(60,7,"Description",1,0,'C',"True");
	$pdf->Cell(40,7,"Value",1,0,'C',"True");
	
} else {
	
	$pdf->Cell(90,7,"Timestamp",1,0,'C',"True");
	$pdf->Cell(90,7,"Value",1,0,'C',"True");
	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFillColor(255,255,255);
	
	$t_array = array(
		array("timestamp"=>"12/12/2019 10:00:00","value"=>"30%"),
		array("timestamp"=>"12/12/2019 10:00:00","value"=>"30%"),
		array("timestamp"=>"12/12/2019 10:00:00","value"=>"30%"),
		array("timestamp"=>"12/12/2019 10:00:00","value"=>"30%"),
		array("timestamp"=>"12/12/2019 10:00:00","value"=>"30%"),
		array("timestamp"=>"12/12/2019 10:00:00","value"=>"30%"),
		array("timestamp"=>"12/12/2019 10:00:00","value"=>"30%"),
		array("timestamp"=>"12/12/2019 10:00:00","value"=>"30%")		
	);
	
	foreach($t_array as $t){
	
		$c_y = $pdf->getY();
		$pdf->SetXY(20,7+$c_y);
		
		$pdf->Cell(90,7,$t['timestamp'],1,0,'C');
		$pdf->Cell(90,7,$t['value'],1,0,'C');
		
	}
	
	
	
		
}

$pdf->Output('',$title.".pdf",true);
?>