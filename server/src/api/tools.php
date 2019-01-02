<?php

function throwError($message){
	header("HTTP/1.1 400 $message");
	if(empty($message)) $message = "An Unknown Error Occurred";
	$array = array(
		"code"=>400,
		"message"=>$message
	);
	echo json_encode($array);	
	die();
}
?>