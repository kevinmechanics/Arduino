<?php
header('Access-Control-Allow-Origin: *');

$time_zone = "Asia/Manila";
date_default_timezone_set($time_zone);

$mysqli = new mysqli($sql_host,$sql_username,$sql_password,$sql_database);
?>