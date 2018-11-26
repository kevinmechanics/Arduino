<?php

session_start();

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Admin.class.php");

$admin = new Admin($mysqli);

$id = strip_tags($_POST['id']);

$admin->delete($id);

header("Location: ".$_SERVER['HTTP_REFERER']);

?>
