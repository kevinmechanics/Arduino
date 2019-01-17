<?php

//if($_SERVER['HTTP_USER_AGENT'] !== "airduino-ph-android-app") die("App Version not supported");

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/User.class.php");

$user = new User($mysqli);

$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);

$login_array = array(
    "username"=>$username,
    "password"=>$password
);

$result = $user->verifyCredentials($login_array);

if($result == True){

    $UserAccount = $user->getByUsername($username);
    unset($UserAccount['password']);

    if($UserAccount == False){
        $response = array(
            "code"=>"500",
            "messsage"=>"Cannot sign you in"
        );
    } else {
        if($result !== True){
            $response = array(
                "code"=>"500",
                "message"=>$result
            );    
        } else {
            $response = array(
                "code"=>"200",
                "message"=>"User is logged in successfully",
                "UserAccount"=>$UserAccount
            );  
        }
        
    
    }

} else {
    $response = array(
        "code"=>"500",
        "messsage"=>$result
    );
}

echo json_encode($response);

?>