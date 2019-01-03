<?php include("_header.php"); ?>
				<div class="col s9">
					<h3>Gateway</h3> <a href="#!" class="btn btn_small">Arduino Only</a>
					
					<p>
						Accessible through https://airduino-ph.000webhostapp.com/gateway/<br>
<br>
<br>
/add.php <span class="btn btn_small">GET</span><br>
	Used for recieving data from the airduino device.<br>
	<br><br><br>
	<b>Parameters:</b><br><br>
		○ device_id <span class="btn btn_small" style="background-color:gray;">String</span> - Device ID used as an identifer for the physical device.<br>
		○ temperature <span class="btn btn_small" style="background-color:gray;">Number</span> - Temperature Reading in Celsius.<br>
		○ air_value <span class="btn btn_small" style="background-color:gray;">Number</span> - Temperature Reading in Parts Per Million (PPM).<br>
		○ air_description <span class="btn btn_small" style="background-color:gray;">String</span> - Description equivalent of the reading for air quality.<br>
		○ humidity <span class="btn btn_small" style="background-color:gray;">Number</span> - Relative Humidity Reading in Percentage.<br>
<br><br><br>
	<b>Return Responses:</b><br><br>
		○ Successfully Added Data <span class="btn btn_small" style="background-color:green;">200</span> - Data is stored without any issues. Take note that the message inside the json object contains 'OK' for backwards compatibility.<br><br>
		○ Error Occurred while adding the data <span class="btn btn_small" style="background-color:red;">401</span> - An unknown error has been encountered. Try sending the request again.<br><br>
		○ Device ID is Required <span class="btn btn_small" style="background-color:red;">401</span> - You might have forgotten to include the device id.<br><br>
		○ Unauthorized and Unknown Device <span class="btn btn_small" style="background-color:red;">401</span> - You have encoded the wrong device id. Try contacting the administrator for the proper device id.<br><br>
		○ An argument might be missing <span class="btn btn_small" style="background-color:red;">401</span> - All of the parameters are needed to be sent even if they are blank.<br>

					</p>
					
</div>
<?php include("_footer.php"); ?>
