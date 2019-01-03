<?php include("_header.php"); ?>
				<div class="col s9">
					<h3>Temperature</h3> <a href="#!" class="btn btn_small">REST</a>
					
					<p>
						Accessible through https://airduino-ph.000webhostapp.com/api/temperature<br>
							<br>
							<br>
							<b>/getLastFifty.php</b> <span class="btn btn_small">GET</span><br>
								Get the last 50 recent temperature data received. Ordered from newest to oldest.<br>
								<br>
								<i>Parameters:</i><br><br>
									○ device_id <span class="btn btn_small" style="background-color:gray;">String</span> - Device ID used as an identifer for the physical device.<br>
							<br>
						</p>
					
</div>
<?php include("_footer.php"); ?>