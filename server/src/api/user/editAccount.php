<?php

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/User.class.php");

$user = new User($mysqli);

$id = strip_tags($_POST['id']);
$first_name = strip_tags($_POST['first_name']);
$last_name = strip_tags($_POST['last_name']);
$username = strip_tags($_POST['username']);
$password = strip_tags($_POST['password']);

$array = array(
    "id"=>$id,
    "first_name"=>$first_name,
    "last_name"=>$last_name,
    "username"=>$username,
    "password"=>$password
);

$result = $user->update($array);

if($result == True){

    $UserAccount = $user->getByUsername($username);
    unset($UserAccount['password']);

    $response = array(
        "code"=>200,
        "message"=>"Account updated successfully",
        "UserAccount"=>$UserAccount
    );

} else {

    $response = array(
        "code"=>500,
        "message"=>"An error occurred"
    );

}

echo json_encode($response);

?>