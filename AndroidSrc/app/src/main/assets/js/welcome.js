$(document).ready(()=>{
    loginCheck();

    $('.dropdown-trigger').dropdown();
    $('.modal').modal();

    clear();
    $(".splashscreen").fadeOut();
    showActivity("welcome");

    setupTerms();

});

var loginCheck = ()=>{
    if(localStorage.getItem('airduino-loggedin')){
        var li = localStorage.getItem('airduino-loggedin');
        if(li == 'true') {
            location.replace('main.html');
        } 
    }
};

var showToast = (msg)=>{
    try {
        Android.showToast(msg);
    } catch(error){
        console.log(error);
        M.toast({html:msg,durationLength:2000});
    }
};

var clear = ()=>{
    $(".activity").hide();
};

var showActivity = (actName)=>{
    clear();
    $(`#${actName}Activity`).fadeIn();
}

var signIn = ()=>{

    var enable = ()=>{
        $("#accountPreloader").hide();
        $("#accountContent").show();
    };

    var disable = ()=>{
        $("#accountContent").hide();
        $("#accountPreloader").show();
    };

    var u = $("#username").val();
    var p = $("#password").val();

    disable();

    if(!u){
        showToast("Username is Required");
        enable();
    } else {
        if(!p){
            showToast("Password is Required");
            enable();
        } else {

            $.ajax({
                type:"POST",
                url:"https://airduino-ph.000webhostapp.com/api/user/appLogin.php",
                data: {
                    username: u,
                    password: p
                },
                cache: 'false',
                success: (result)=>{
                    result = JSON.parse(result);
                    console.log(result);
                    if(result.code == 200){

                        localStorage.setItem("airduino-loggedin","true");
                        localStorage.setItem("airduino-user",JSON.stringify(result.UserAccount));
                        location.replace('main.html');

                    } else {
                        enable();
                        showToast("Sign In details might be incorrect");
                    }
                }
            }).fail((error)=>{
                console.log(error);
                showToast("Cannot connect to server");
                enable();
            });

        }
    }

}

var register = ()=>{

    var enable = ()=>{
        $("#registerPreloader").hide();
        $("#registerContent").show();
    };

    var disable = ()=>{
        $("#registerContent").hide();
        $("#registerPreloader").show();
    };


    var fn = $("#Rfirst_name").val();
    var ln = $("#Rlast_name").val();
    var u = $("#Rusername").val();
    var p = $("#Rpassword").val();

    disable();

    if(!u){
        enable();
        showToast("Username is Required");
    } else {
        if(!p){
            enable();
            showToast("Password is Required");
        } else {
            if(!fn){
                enable();
                showToast("First Name is Required");
            } else {
                if(!ln){
                    enable();
                    showToast("Last Name is Required");
                } else {

                    $.ajax({
                        type:"POST",
                        url:"https://airduino-ph.000webhostapp.com/api/user/register.php",
                        cache:'false',
                        data: {
                            first_name: fn,
                            last_name: ln,
                            username: u,
                            password: p
                        },
                        success: (result)=>{
                            console.log(result);
                            result = JSON.parse(result);
                            if(result.code == 200){

                                localStorage.setItem("airduino-loggedin","true");
                                localStorage.setItem("airduino-user",JSON.stringify(result.UserAccount));
                                location.replace('main.html');
        
                            } else {
                                enable();
                                showToast(result.message);
                            }
                        }

                    }).fail(()=>{
                        enable();
                        showToast("Cannot connect to server");
                    })

                }
            }
        }
    }

}