<?php

if($_SERVER['HTTP_USER_AGENT'] !== "airduino-ph-android-app") die("App Version not supported");

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Newsfeed.class.php");

$newsfeed = new Newsfeed($mysqli);

$result = $newsfeed->getAll();

echo json_encode($result);

?>