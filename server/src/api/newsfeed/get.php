<?php

session_start();

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Newsfeed.class.php");

$newsfeed = new Newsfeed($mysqli);

$id = strip_tags($_POST['id']);

$result = $newsfeed->get($id);

echo json_encode($result);

?>
