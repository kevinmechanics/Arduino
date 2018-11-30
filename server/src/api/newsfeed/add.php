<?php

session_start();

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Newsfeed.class.php");

$newsfeed = new Newsfeed($mysqli);

$title = strip_tags($_POST['title']);
$content = strip_tags($_POST['content']);

$array = array(
	"title"=>$title,
	"content"=>$content
);

$newsfeed->add($array);

header("Location: ".$_SERVER['HTTP_REFERER']);

?>
