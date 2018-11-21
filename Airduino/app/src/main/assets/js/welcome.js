$(document).ready(()=>{
    loginCheck();

    $('.dropdown-trigger').dropdown();
    $('.modal').modal();

    clear();
    $(".splashscreen").fadeOut();
    showActivity("welcome");
});

var loginCheck = ()=>{
    if(localStorage.getItem('airduino-loggedin')){
        var li = localStorage.getItem('airduino-loggedin');
        if(li == 'true') {
            location.replace('main.html');
        } 
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
        M.toast({html:"Username is Required",durationLength:3000});
        enable();
    } else {
        if(!p){
            M.toast({html:"Password is Required",durationLength:3000});
            enable();
        } else {

            $.ajax({
                type:"POST",
                url:"sample.html",
                data: {
                    username: u,
                    password: p
                },
                cache: 'false',
                success: (result)=>{
                    if(result.code == 200){

                        localStorage.setItem("airduino-loggedin","true");
                        localStorage.setItem("airduino-user",JSON.stringify(result.UserAccount));
                        window.location('main.html');

                    } else {
                        enable();
                        M.toast({html:"Sign In details might be incorrect", durationLength:3000});
                    }
                }
            }).fail(()=>{
                M.toast({html:"Cannot connect to server", durationLength:3000});
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
        M.toast({html:"Username is Required",durationLength:3000});
    } else {
        if(!p){
            enable();
            M.toast({html:"Password is Required",durationLength:3000});
        } else {
            if(!fn){
                enable();
                M.toast({html:"First Name is Required",durationLength:3000});
            } else {
                if(!ln){
                    enable();
                    M.toast({html:"Last Name is Required",durationLength:3000});
                } else {

                    $.ajax({
                        type:"POST",
                        url:"sample.html",
                        cache:'false',
                        data: {
                            first_name: fn,
                            last_name: ln,
                            username: u,
                            password: p
                        },
                        success: (result)=>{
                            if(result.code == 200){

                                localStorage.setItem("airduino-loggedin","true");
                                localStorage.setItem("airduino-user",JSON.stringify(result.UserAccount));
                                window.location('main.html');
        
                            } else {
                                enable();
                                M.toast({html:"An error occurred while making the account", durationLength:3000});
                            }
                        }

                    }).fail(()=>{
                        enable();
                        M.toast({html:"Cannot connect to server", durationLength:3000});
                    })

                }
            }
        }
    }

}