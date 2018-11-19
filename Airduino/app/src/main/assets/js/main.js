$(document).ready(function(){
    loginCheck();
    $('.tabs').tabs();
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