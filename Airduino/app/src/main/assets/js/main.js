$(document).ready(function(){
    //loginCheck();
    $('.dropdown-trigger').dropdown();
    $('.modal').modal();
    $('.tabs').tabs();

    hideWindowedBar();
    clear();
    $(".splashscreen").fadeOut();
    prepareAccount();
    prepareHome();

    showActivity("home");
});

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
var showActivity = (actName)=>{ clear(); $(`#${actName}Activity`).fadeIn(); };

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
    //var savedDevices = getSavedDevices();
    var savedDevices = [
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
    ];
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
                var tpl = `
                    <h4>${element.location}</h4>
                    <p>${element.city}</p>
                    <div class="row">
                        <div class="col s6">
                            <h1 class="blue-text text-darken-2">30°C</h1>
                            <p>78% Humidity</p>
                        </div>
                        <div class="col s6">
                        <br>
                            <p style="font-size:-1;">Air Quality</p>
                            <h5 class="blue-text">Moderate</h5>
                            <p>at 93 PPM</p>
                        </div>
                    </div>
                    <p class="grey-text">As of Nov 20 4:55 PM</p>
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
                            <div class="circle_button_small blue lighten-2" style="border:0px;">
                                <i class="material-icons white-text">tonality</i>
                            </div>
                            <p class="grey-text darken-1">Air Quality</p>
                        </div>
                    </div>
                    
                    <br><br><br>
                `;
                $("#homeDevicesList").append(tpl);
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

    if(navigator.onLine){
        $.ajax({
            type:'GET',
            url:'sample.html',
            data: {
                device_id:id
            },
            success: result=>{
                localStorage[`airduino-temperature-${id}`] = JSON.stringify(result);
                return JSON.parse(result);
            }
        }).fail(()=>{
            if(localStorage[`airduino-temperature-${id}`]){
                return JSON.parse(localStorage[`airduino-temperature-${id}`]);
            } else {
                return [];
            }
        });
    } else {
        if(localStorage[`airduino-temperature-${id}`]){
            return JSON.parse(localStorage[`airduino-temperature-${id}`]);
        } else {
            return [];
        }
    }
    
}

var launchTemperature = (id)=>{
    try {
        var device = getSavedDeviceInfo(id);
        var result = getTemperatureObject();

        $("#Tlocation").html(device.location);
        $("#Tcity").html(device.city);

        hideNavbar();
        hideBottombar();
        showWindowedBar();
        showActivity("temperature");
        $('html,body').animate({scrollTop:0},'medium');
    } catch (error) {
        M.toast({html:"Cannot load temperature",durationLength:3000});
        console.log(error);
    }
};

var launchHumidity = (id)=>{
    try {

        var device = getSavedDeviceInfo(id);
        var result = getTemperatureObject();

        $("#Hlocation").html(device.location);
        $("#Hcity").html(device.city);

        hideNavbar();
        hideBottombar();
        showWindowedBar();
        showActivity('humidity');
        $('html,body').animate({scrollTop:0},'medium');
    } catch(error){
        M.toast({html:"Cannot load humidity",durationLength:3000});
        console.log(error);
    }
}