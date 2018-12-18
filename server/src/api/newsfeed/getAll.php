<?php

session_start();

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Newsfeed.class.php");

$newsfeed = new Newsfeed($mysqli);

$result = $newsfeed->getAll();

echo json_encode($result);

?>
