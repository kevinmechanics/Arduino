<?php

require_once("../../_system/keys.php");
require_once("../../_system/db.php");
require_once("../../class/Temperature.class.php");

$temperature = new Temperature($mysqli);

$count = 100;
$low = 20;
$high = 38;

while($count !== 0){

    $rand = rand($low,$high);

    $array = array(
        "device_id"=>1,
        "value"=>$rand
    );

    $temperature->add($array);

    echo "$count done";

    $count = $count - 1;
}

?>