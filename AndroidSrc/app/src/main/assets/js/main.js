$(document).ready(function(){
    //loginCheck();
    $('.dropdown-trigger').dropdown();
    $('.modal').modal();
    $('.tabs').tabs();

    var sd = getSavedDevices();
    try {
        sd.forEach(element=>{
            getTemperatureObject(element.device_id);
            getHumidityObject(element.device_id);
            getAirQualityObject(element.device_id);
        });
    } catch(e){
        console.log(e);
    }

    hideWindowedBar();
    clear();
    $(".splashscreen").fadeOut();
	setupNewsFeed();
    prepareAccount();
    prepareHome();

    showActivity("home");

    setupTerms();

    setInterval(()=>{
        getTemperatureObject(element.device_id);
        getHumidityObject(element.device_id);
        getAirQualityObject(element.device_id);
        prepareHome();
    },120000);

});

var showToast = (msg)=>{
    try {
        Android.showToast(msg);
    } catch(error){
        console.log({
            "Message":"Cannot fire up native toast. You might be debugging in a web browser.",
            "Content":msg
        });
        M.toast({html:msg,durationLength:2000});
    }
};

var loginCheck = ()=>{
    if(localStorage.getItem('airduino-loggedin')){
        var li = localStorage.getItem('airduino-loggedin');
        if(li != 'true') {
            location.replace('welcome.html');
        }
    } else {
        location.replace('welcome.html');
    }
};


// activity
var clear = ()=>{ $(".activity").hide(); };
var showActivity = (actName)=>{ clear(); $(`#${actName}Activity`).fadeIn(); $('html,body').animate({scrollTop:0},'fast'); };

// navbar
var hideNavbar = ()=>{ $("#regularNavbar").hide(); };
var showNavbar = ()=>{ $("#regularNavbar").show(); };

// bottombar
var showBottombar = ()=>{ $(".bottombar").show(); };
var hideBottombar = ()=>{ $(".bottombar").hide(); };

// windowed bar
var hideWindowedBar = ()=>{ $("#windowedNavbar").hide(); };
var showWindowedBar = ()=>{ $("#windowedNavbar").show(); };

var showPreloader = ()=>{
    hideNavbar();
    hideWindowedBar();
    hideBottombar();
    showActivity('preloader');
};

var hidePreloader = ()=>{
    clear();
    showNavbar();
    showBottombar();
};

var refreshActivity = ()=>{
    hideWindowedBar();
    showNavbar();
    showBottombar();
}


var getSavedDevices = ()=>{
    if(localStorage.getItem("airduino-devices")){
        var devices = JSON.parse(localStorage.getItem("airduino-devices"));
        if(devices == ""){
            return [];
        } else {
            return devices;
        }
    } else {
        return [];
    }
}

var getAccount = ()=>{
    if(localStorage.getItem("airduino-user")){
        return JSON.parse(localStorage.getItem("airduino-user"));
    } else {
        return {};
    }
}

var prepareAccount = ()=>{
    var account = getAccount();
    var fn = account['first_name'];
    var ln = account['last_name'];
    var u = account['username'];
    var i = account['id'];

    $(".first_name").html(fn);
    $(".last_name").html(ln);
    $(".username").html(u);

    $("#Afirst_name").val(fn);
    $("#Alast_name").val(ln);
    $("#Ausername").val(u);

    M.updateTextFields();
    
}

var prepareHome = ()=>{
    var savedDevices = getSavedDevices();
    /*var savedDevices = [
        {
            "id":1,
            "location":"Brgy. Sta Fe",
            "city":"Dasmarinas City"
        },
        {
            "id":2,
            "location":"Brgy. Commonwealth",
            "city":"Quezon City"
        }
    ];*/

    if(savedDevices == ""){
        $("#homeDevices").hide();
        $("#homeEmptyDevices").show();
    } else {

        if(savedDevices == []){
            $("#homeDevices").hide();
            $("#homeEmptyDevices").show();
        } else {
            $("#homeDevicesList").html("");
            savedDevices.forEach(element => {

                try {

                    getTemperatureObject(element.device_id);
                    getHumidityObject(element.device_id);
                    getAirQualityObject(element.device_id);

                    var temp = JSON.parse(localStorage.getItem(`airduino-temperature-${element.device_id}`));
                    var hum = JSON.parse(localStorage.getItem(`airduino-humidity-${element.device_id}`));
                    var air = JSON.parse(localStorage.getItem(`airduino-airquality-${element.device_id}`));

                    console.log(hum);

                    temp = temp[temp.length - 1];
                    hum = hum[hum.length - 1];
                    air = air[air.length - 1];

                    var ts = new Date(temp.timestamp);

                    var tpl = `
                        <h4>${element.location}</h4>
                        <p>${element.city}</p>
                        <div class="row">
                            <div class="col s6">
                                <h1 class="blue-text text-darken-2">${temp.value}°C</h1>
                                <p>${hum.value}% Humidity</p>
                            </div>
                            <div class="col s6">
                            <br>
                                <p style="font-size:-1;">Air Quality</p>
                                <h5 class="blue-text">${air.description}</h5>
                                <p>at ${air.value} PPM</p>
                            </div>
                        </div>
                        <p class="grey-text">As of ${ts.toDateString()} (${ts.toLocaleTimeString()})</p>
                        <br><br>
                        <div class="row">
                            <div class="col s4">
                                <a href="#!" onclick="launchTemperature('${element.id}');">
                                    <div class="circle_button_small red lighten-2" style="border:0px;">
                                        <i class="material-icons white-text">wb_sunny</i>
                                    </div>
                                    <p class="grey-text darken-1">Temperature</p>
                                </a>
                            </div>
                            <div class="col s4">
                                <a href="#!" onclick="launchHumidity('${element.id}');">
                                    <div class="circle_button_small green lighten-2" style="border:0px;">
                                        <i class="material-icons white-text">cloud</i>
                                    </div>
                                    <p class="grey-text darken-1">Humidity</p>
                                </a>
                            </div>
                            <div class="col s4">
                                <a href="#!" onclick="launchAirQuality('${element.id}');">
                                    <div class="circle_button_small blue lighten-2" style="border:0px;">
                                        <i class="material-icons white-text">tonality</i>
                                    </div>
                                    <p class="grey-text darken-1">Air Quality</p>
                                </a>
                            </div>
                        </div>
                        
                        <br><br><br>
                    `;
                    $("#homeDevicesList").append(tpl);
    
                } catch(e){

                    console.log(e);

                    var tpl = `
                        <h4>${element.location}</h4>
                        <p>${element.city}</p>
                        <br><br>
                        <div class="row">
                            <div class="col s4">
                                <a href="#!" onclick="launchTemperature('${element.id}');">
                                    <div class="circle_button_small red lighten-2" style="border:0px;">
                                        <i class="material-icons white-text">wb_sunny</i>
                                    </div>
                                    <p class="grey-text darken-1">Temperature</p>
                                </a>
                            </div>
                            <div class="col s4">
                                <a href="#!" onclick="launchHumidity('${element.id}');">
                                    <div class="circle_button_small green lighten-2" style="border:0px;">
                                        <i class="material-icons white-text">cloud</i>
                                    </div>
                                    <p class="grey-text darken-1">Humidity</p>
                                </a>
                            </div>
                            <div class="col s4">
                                <a href="#!" onclick="launchAirQuality('${element.id}');">
                                    <div class="circle_button_small blue lighten-2" style="border:0px;">
                                        <i class="material-icons white-text">tonality</i>
                                    </div>
                                    <p class="grey-text darken-1">Air Quality</p>
                                </a>
                            </div>
                        </div>
                        
                        <br><br><br>
                    `;

                    $("#homeDevicesList").append(tpl);

                }
            });

            $("#homeEmptyDevices").hide();
            $("#homeDevices").show();
        }
        
    }
}

var getSavedDeviceInfo = (id)=>{
    var devices = getSavedDevices();
    try {
        return devices.find(obj=>{if(obj.id == id) return obj;});
    } catch (error) {
        return {};
    }
}

var getTemperatureObject = (id)=>{

    $.ajax({
        type:'GET',
        url:'https://airduino-ph.000webhostapp.com/api/temperature/getLastFifty.php',
        data: {
            device_id:id
        },
        success: result=>{
            result = JSON.parse(result);
            localStorage.setItem(`airduino-temperature-${id}`,JSON.stringify(result));
        }
    }).fail((error)=>{            
        console.log(error);
    });
    
}

var getHumidityObject = (id)=>{

    $.ajax({
        type:'GET',
        url:'https://airduino-ph.000webhostapp.com/api/humidity/getLastFifty.php',
        data: {
            device_id:id
        },
        success: result=>{
            result = JSON.parse(result);
            localStorage.setItem(`airduino-humidity-${id}`,JSON.stringify(result));
        }
    }).fail((error)=>{            
        console.log(error);
    });
    
};

var getAirQualityObject = (id)=>{

    $.ajax({
        type:'GET',
        url:'https://airduino-ph.000webhostapp.com/api/airquality/getLastFifty.php',
        data: {
            device_id:id
        },
        success: result=>{
            result = JSON.parse(result);
            localStorage.setItem(`airduino-airquality-${id}`,JSON.stringify(result));
        }
    }).fail((error)=>{            
        console.log(error);
    });
    
};

var launchTemperature = (id)=>{
    try {
        var device = getSavedDeviceInfo(id);
        getTemperatureObject(device.device_id);

        var result = localStorage.getItem(`airduino-temperature-${device.device_id}`);

        try {
            result = JSON.parse(result);
            $("#Tlocation").html(device.location);
            $("#Tcity").html(device.city);
    
            var latest = result[result.length - 1];
   
            var ts = new Date(latest.timestamp);
            ts = `${ts.toDateString()} (${ts.toLocaleTimeString()})`;
    
    
            $("#Ttemperature").html(`${latest.value}°C`);
            $("#Tdatetime").html(ts);
    
            var time_labels = [];
            var temp_data = [];
    
            $("#Thistory").html("");
            
            if(result.length > 5){
                var resultSlice = result.slice(result.length - 5);
            } else {
                var resultSlice = result;
            }

            resultSlice.forEach(element=>{
                var date = new Date(element.timestamp);
                var time = date.toLocaleTimeString();
                time_labels.push(time);
    
                temp_data.push(element.value);
            });
    
            if(result.length > 10){
                result = result.slice(result.length - 10);
            }

            result.forEach(element=>{
                var date = new Date(element.timestamp);
    
                var tpl = `
                    <li class="collection-item">
                        <p>${element.value}°C</p>
                        <p style="font-size:8pt;" class="grey-text">${date.toDateString()} - ${date.toLocaleTimeString()}</p>
                    </li>
                `;
    
                $("#Thistory").append(tpl);
    
            });
    
            new Chart(
                document.getElementById("Tchart"),{
                    "type":"line",
                    "data":{
                        "labels":time_labels,
                        "datasets":
                        [
                            {
                                "label":"Temperature","data":temp_data,
                                "fill":false,
                                "borderColor":"#1e88e5",
                                "lineTension":0.01
                            }
                        ]
                    },
                    "options":{}
                }
            );
    
            hideNavbar();
            hideBottombar();
            showWindowedBar();
            showActivity("temperature");
            $('html,body').animate({scrollTop:0},'medium');
    

        } catch(e){
            showToast("No available data yet");
            console.log(e);
        }

    } catch (error) {
        showToast("Cannot load temperature");
        console.log(error);
    }
};

var launchHumidity = (id)=>{
    try {

        var device = getSavedDeviceInfo(id);
        getHumidityObject(device.device_id);
        
        try {

            result = JSON.parse(localStorage.getItem(`airduino-humidity-${device.device_id}`));

            $("#Hlocation").html(device.location);
            $("#Hcity").html(device.city);

            var latest = result[result.length - 1];
            var ts = new Date(latest.timestamp);
            $("#Hpercentage").html(latest.value + "%");
            $("#Hdatetime").html(`${ts.toDateString()} (${ts.toLocaleTimeString()})`);

            $("#Hhistory").html("");

            var time_labels = [];
            var temp_data = [];

            if(result.length > 10){
                var resultSlice = result.slice(result.length - 10);
            } else {
                var resultSlice = result;
            }
            resultSlice.forEach(element=>{
                var date = new Date(element.timestamp);
                var time = date.toLocaleTimeString();
                time_labels.push(time);
    
                temp_data.push(element.value);
            });
    
            if(result.length > 10){
                result = result.slice(result.length - 10);
            }
            result.forEach(element=>{
                var date = new Date(element.timestamp);
    
                var tpl = `
                    <li class="collection-item">
                        <p>${element.value}%</p>
                        <p style="font-size:8pt;" class="grey-text">${date.toDateString()} - ${date.toLocaleTimeString()}</p>
                    </li>
                `;
    
                $("#Hhistory").append(tpl);
    
            });

            new Chart(
                document.getElementById("Hchart"),{
                    "type":"line",
                    "data":{
                        "labels":time_labels,
                        "datasets":
                        [
                            {
                                "label":"Humidity","data":temp_data,
                                "fill":false,
                                "borderColor":"#1e88e5",
                                "lineTension":0.01
                            }
                        ]
                    },
                    "options":{}
                }
            );

            hideNavbar();
            hideBottombar();
            showWindowedBar();
            showActivity('humidity');
            $('html,body').animate({scrollTop:0},'medium');
            

        } catch(error){
            showToast("No available data yet");
        }
    } catch(error){
        showToast("Cannot load humidity");
        console.log(error);
    }
};

var launchAirQuality = (id)=>{
	try {

        var device = getSavedDeviceInfo(id);
        
        var result = JSON.parse(localStorage.getItem(`airduino-airquality-${device.device_id}`));
        
 								try {

	        var latest = result[result.length - 1];
	
	        $("#Alocation").html(device.location);
	        $("#Acity").html(device.city);
	
	        var lValue = latest.value;
	        var lDescription = latest.description;
	
	        $("#Aquality").html(`<b>${lDescription} </b><br>${lValue} PPM`);
	
	        var ts = new Date(latest.timestamp);
	        ts = `${ts.toDateString()} (${ts.toLocaleTimeString()})`;
	
	        $("Adatetime").html(ts);
	
	        var time_labels = [];
	        var temp_data = [];
	
	        $("#Hhistory").html("");
	        
	        if(result.length > 10){
	            var resultSlice = result.slice(result.length - 10);
	        } else {
	            var resultSlice = result;
	        }
	        resultSlice.forEach(element=>{
	            var date = new Date(element.timestamp);
	            var time = date.toLocaleTimeString();
	            time_labels.push(time);
	
	            temp_data.push(element.value);
	        });
	
	        if(result.length > 10){
	            result = result.slice(result.length - 10);
	        }
	        result.forEach(element=>{
	            var date = new Date(element.timestamp);
	
	            var tpl = `
	                <li class="collection-item">
	                    <p>${element.description} at ${element.value} PPM</p>
	                    <p style="font-size:8pt;" class="grey-text">${date.toDateString()} - ${date.toLocaleTimeString()}</p>
	                </li>
	            `;
	
	            $("#Hhistory").append(tpl);
	
	        });
	
	            new Chart(
	                document.getElementById("Achart"),{
	                    "type":"line",
	                    "data":{
	                        "labels":time_labels,
	                        "datasets":
	                        [
	                            {
	                                "label":"Air Quality","data":temp_data,
	                                "fill":false,
	                                "borderColor":"#1e88e5",
	                                "lineTension":0.01
	                            }
	                        ]
	                    },
	                    "options":{}
	                }
	            );
	
	        hideNavbar();
	        hideBottombar();
	        showWindowedBar();
	        showActivity('airquality');
	        $('html,body').animate({scrollTop:0},'medium');
	       } catch(error){
	       	
											showToast("No available data yet");
												       	
	       }

	    } catch(error){
        showToast("Cannot load air quality");
        console.log(error);
    }
};

var setupNewsFeed = ()=>{
	var emptyFeed = `<center><p>No Alerts Yet</p></center>`;
	var populate = ()=>{
		$("#newsfeedList").html("");
		if(localStorage.getItem('airduino-newsfeed')){
            var entries = JSON.parse(localStorage.getItem('airduino-newsfeed'));
            var entries = entries.reverse();
			if(entries != []){
				entries.forEach(element=>{
					var tpl =  `
							<div class="card">
								<div class="card-content">
									<h5>${element.title}</h5>
									<p>${element.content}</p><br>
									<p style="font-size:8pt;" class="grey-text">${element.timestamp_created}</p>
								</div>
						</div>`;
					$("#newsfeedList").append(tpl);
				});
			} else {
				$("#newsfeedList").html(emptyFeed);
			}
			
		} else {
			$("#newsfeedList").html(emptyFeed);
		}

	};
	
	try {
        
		if(navigator.onLine){
			$.ajax({
				type:"GET",
				url: "https://airduino-ph.000webhostapp.com/api/newsfeed/getAll.php",
				cache: 'false',
				success: result=>{
					localStorage.setItem("airduino-newsfeed", result);
					populate();
				}
			}).fail((error)=>{
                console.log(error);
				populate();
			});
		} else {
			populate();
		}
	} catch(error) {
		console.log(error);
		populate();
	}
};

var launchAddStation = ()=>{
    showPreloader();

    if(navigator.onLine){

        $("#addStationList").html("");

        $.ajax({
            type:"GET",
            cache:"false",
            url:"https://airduino-ph.000webhostapp.com/api/device/getAll.php",
            success: result=>{
                var result = JSON.parse(result);
                result.forEach(element=>{
                    if(!getSavedDeviceInfo(element.id)){

                        var ls = JSON.stringify(element);
                        
                        var colors = ["red", "blue-grey", "green", "blue", "orange","grey","amber"];
                        var randColor = colors[Math.floor(Math.random()*colors.length)];

                        var tpl = `
                            <div class="card ${randColor} darken-2 white-text" style="box-shadow: 0 20px 40px rgba(92, 92, 92, 0.3);">
                                <div class="card-content">
                                    <h5>${element.location}</h5>
                                    <p>${element.city}</p>
                                </div>
                                <div class="card-action">
                                    <a href="#!" id="StationAdd${element.id}" class="white-text">Add</a>
                                </div>
                            </div>
                            <script>
                                $("#StationAdd${element.id}").click(()=>{
                                    addSavedStation('${ls}');
                                    prepareHome();
                                    showBottombar();
                                    hideWindowedBar();
                                    showNavbar();
                                    showActivity("home");
                                    showToast("Added ${element.location} to saved stations");
                                });
                            </script>
                        `;
                        $("#addStationList").append(tpl);

                    }
                    
                });

                var asl = $("#addStationList").html();
                if(!asl){
                    var tpl = `
                        <center><p>No new Airduino stations available yet.</p></center>
                    `;
                    $("#addStationList").html(tpl);
                }

                clear();
                hideNavbar();
                hideBottombar();
                showWindowedBar();
                showActivity('addstation');
                
            }
        }).fail(()=>{
            showToast("Cannot open stations list");
            hidePreloader();
            showActivity("home");                
        });

    } else {
        showToast("Offline. Cannot open stations list.");
        hidePreloader();
        showActivity("home");
    }
};