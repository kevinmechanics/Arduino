<?php

session_start();

if(empty($_SESSION['loggedin'])) die("Unauthorized");

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Newsfeed.class.php");

$newsfeed = new Newsfeed($mysqli);

$id = strip_tags($_REQUEST['id']);
$title = strip_tags($_POST['title']);
$content = strip_tags($_POST['content']);

$array = array(
	"id"=>$id,
	"title"=>$title,
	"content"=>$content
);

$newsfeed->update($array);

header("Location: ".$_SERVER['HTTP_REFERER']);

?>