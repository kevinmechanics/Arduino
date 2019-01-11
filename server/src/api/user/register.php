<?php

if($_SERVER['HTTP_USER_AGENT'] !== "airduino-ph-android-app") die("App Version not supported");

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/User.class.php");

$user = new User($mysqli);

$first_name = strip_tags($_POST['first_name']);
$last_name = strip_tags($_POST['last_name']);
$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);
$email = strip_tags($_POST['email']);

$array = array(
    "first_name"=>$first_name,
    "last_name"=>$last_name,
    "username"=>$username,
    "password"=>$password,
    "email"=>$email
);

if($user->getByUsername($username) == False){

    $result = $user->add($array);

    if($result == True){

        $UserAccount = $user->getByUsername($username);
        unset($UserAccount['password']);

        $response = array(
            "code"=>200,
            "message"=>"User registered successfully",
            "UserAccount"=>$UserAccount
        );

    } else {

        $response = array(
            "code"=>500,
            "message"=>"An unknown error occurred"
        );

    }

} else {
    $response = array(
        "code"=>500,
        "message"=>"Username already registered"
    );
}

echo json_encode($response);

?>