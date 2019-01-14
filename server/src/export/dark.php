<?php
$device_id = "DEBUG";
$data_cat = "temperature";
$device_info = array(
	"device_id"=>"DEBUG",
	"location"=>"Sample Location",
	"city"=>"Sample City"
);

if(!empty($_GET['device_id'])) $device_id = urlencode(strip_tags($_GET['device_id']));
if(!empty($_GET['data_cat'])) $data_cat = strip_tags($_GET['data_cat']);

require_once("../_system/keys.php");
require_once("../_system/db.php");
require_once("../class/Device.class.php");

$device = new Device($mysqli);
$device_info = $device->getByDeviceId($device_id);
?>
<!Doctype html>
<html>
    <head>
        <title>Airduino</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="/export/assets/materialize/css/materialize.css">
        <link rel="stylesheet" type="text/css" href="/export/assets/iconfont/material-icons.css">
        <link rel="stylesheet" type="text/css" href="/export/assets/montserrat/icon.css">
        <link rel="stylesheet" type="text/css" href="/export/assets/style.css">
        <script src="/export/assets/js/jquery-3.3.1.min.js"></script>
        <script src="/export/assets/materialize/js/materialize.min.js"></script>
        <style>
        
        input[type='datetime-local']{
        		color:white !important;
        }
        
        </style>
    </head>
    <body class="blue-grey darken-4 white-text">

        <div class="splashscreen grey darken-2">
        </div>

		<div class="statusbar grey lighten-1" style="background-color:#1e282c !important;">
		  
		</div>
		
        <!-- regular navbar -->
        <nav class='navbar blue-grey darken-4 z-depth-0' id="regularNavbar">
            <div class="left" style="margin-left:5%">
            		<a href='#' onclick="window.history.back()"><i class="material-icons white-text">arrow_back</i></a>
            </div>
        </nav>
        <!-- regular navbar -->


        <!-- universal preloader -->
        <div class="activity" id="preloaderActivity">
            <div class="container" style="width:100%; height:150%">
                <center>
                    <br><br><br><br><br><br><br><br>
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                            <div class="circle"></div>
                            </div><div class="gap-patch">
                            <div class="circle"></div>
                            </div><div class="circle-clipper right">
                            <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                    <p>Please Wait</p>
                </center>
            </div>
        </div>
        <!-- universal preloader -->

		<!--export activity-->
		<div class="activity" id="homeActivity">
			<div class="content" style="margin-left:5%; margin-right:5%">
					<h4>Export Data for <?php echo $device_info['location'] . " (" .$device_info['city'] . ")"; ?></h4>
					<br>
					<div class="input-field">
						<p>Select Data</p>
						<select class="browser-default" id="dataChooser">
						<?php
							
							$data_cat_arr = array("All"=>"ALL","Temperature"=>"temperature","Humidity"=>"humidity","Air Quality"=>"airquality");
							
							foreach($data_cat_arr as $key=>$value){
								if($value == $data_cat){
									echo "<option value='$value' selected>$key</option>";
								} else {
									echo "<option value='$value'>$key</option>";
								}
							}
						
						?>
						</select>
					</div>
						
					<div class="input-field">
						<p>Start Date</p>
						<input type="datetime-local" id="startdate"></input>
					</div>
					<div class="input-field">
						<p>End Date</p>
						<input type="datetime-local" id="enddate"></input>
					</div>
					<br>
					<br>
					<button class="btn btn-large blue darken-2" onclick="download('pdf')">Download PDF</button><br><br>
					<button class="btn btn-large blue darken-2" onclick="download('xlsx')">Download XLSX</button>
			
			<br><br><br><br><br>
			</div>
		</div>
		<!--.export activity-->
		
	</div>
</body>
</html>
<script>
$(document).ready(()=>{
	$(".splashscreen").fadeOut();		
	$("#preloaderActivity").hide();
	showActivity('home');
});

var clear = ()=>{
	$(".activity").hide();	
};

var showActivity = (activity)=>{
	$(`#${activity}Activity`).show();
};

var showToast = (msg)=>{
    try {
        Android.showToast(msg);
    } catch(error){
        console.log(error);
        M.toast({html:msg,durationLength:2000});
    }
};

var download = (format)=>{
	
	var datac = $("#dataChooser").val();
	var startdate = $("#startdate").val();
	var enddate = $("#enddate").val();
	
	if(!datac){
			showToast("Data category is required");
	} else {
		
		startdate = encodeURIComponent(startdate);
		enddate = encodeURIComponent(enddate);
		
			if(format == "pdf"){
				 window.open(`http://airduino-ph.000webhostapp.com/export/downloadPdf.php?device_id=<?php echo $device_id; ?>&data_cat=${datac}&startdate=${startdate}&enddate=${enddate}`);	
			} else {
				window.open(`http://airduino-ph.000webhostapp.com/export/downloadXlsx.php?device_id=<?php echo $device_id; ?>&data_cat=${datac}&startdate=${startdate}&enddate=${enddate}`);	
			}
			
		
	}
	
}
</script>