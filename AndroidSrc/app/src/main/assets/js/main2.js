var prepareSavedStations = ()=>{
    var stations = getSavedDevices();
    $("#savedStationsListManage").html("");
    stations.forEach((element,index)=>{
        var tpl = `
            <li class='collection-item'>
                <p>
                    ${element.location} - ${element.city}
                </p>
                <br>
                <a class="red-text" href="#!" onclick="deleteSavedStation('${element.id}');">Remove</a>
            </li>
        `;
        $("#savedStationsListManage").append(tpl);
    });

    var sslm = $("#savedStationsListManage").html();
    if(sslm == ""){
        var tpl = `
        <li class="collection-item">
            <center><p>No saved stations yet</p></center>
        </li>`;
        $("#savedStationsListManage").html(tpl);
    }
}

var addSavedStation = (obj)=>{
    var obj = JSON.parse(obj);
    var stations = JSON.parse(localStorage.getItem("airduino-devices"));
    if(!stations){
        stations = [];
    }
    stations.push(obj);
    localStorage.setItem("airduino-devices",JSON.stringify(stations));

    getTemperatureObject(obj.device_id);
    getHumidityObject(obj.device_id);
    getAirQualityObject(obj.device_id);
    
    prepareHome();
};

var deleteSavedStation = (id)=>{
    var stations = getSavedDevices();
    var stations = stations.filter(obj=>{ if(obj.id != id) return obj; })
    console.log(stations);
    localStorage.setItem("airduino-devices",JSON.stringify(stations));
    prepareHome();
    prepareSavedStations();
    showToast("Station has been removed successfully!");
}

var editAccount = ()=>{

    var disable = ()=>{
        $(".editAccField").attr("disabled","disabled");
    };

    var enable = ()=>{
        $(".editAccField").removeAttr("disabled");
    };

    disable();

    var acct = JSON.parse(localStorage.getItem("airduino-user"));
    var i = acct.id;
    var fn = $("#Afirst_name").val();
    var ln = $("#Alast_name").val();
    var u = $("#Ausername").val();
    var p = $("#Apassword").val();

    if(!fn){
        enable();
        showToast("First name is Required");
    } else {
        if(!ln){
            enable();
            showToast("Last name is Required");
        } else {
            if(!u){
                enable();
                showToast("Username is Required");
            } else {

                $.ajax({
                    type:"POST",
                    cache:'false',
                    url:"https://airduino-ph.000webhostapp.com/api/user/editAccount.php",
                    data: {
                        id:i,
                        first_name:fn,
                        last_name:ln,
                        username:u,
                        password:p
                    },
                    success: result=>{
                        result = JSON.parse(result);

                        if(result.code){

                            if(result.code == 200){

                                localStorage.setItem("airduino-user",JSON.stringify(result.UserAccount));
                                prepareAccount();

                                enable();

                            } else {
                                showToast(result.message);
                                enable();
                            }

                        } else {
                            showToast("An unknown error occurred");
                            enable();
                        }

                    }
                }).fail(()=>{
                    showToast("Cannot connect to server");
                    enable();
                });

            }
        }
    }

};