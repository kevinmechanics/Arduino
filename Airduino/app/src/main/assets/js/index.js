$(document).ready(()=>{

});

function getSensorData(){
    if(localStorage.getItem("airduino-sensor-data")){
        return localStorage.getItem("airduino-sensor-data")
    } else {
        return {};
    }
}

function fetchSensorData(){
    $.ajax({
        type:"GET",
    })
}