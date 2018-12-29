<?php

class Humidity {
	
	private $mysqli;
	
	public $id;
	public $device_id;
	public $value;
	public $timestamp;

	function __construct($mysqli){
		$this->mysqli = $mysqli;
	}

	public function get(Int $id){
		$this->id = $id;
		$stmt = $this->mysqli->prepare("SELECT * FROM `humidity` WHERE `id`=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		$stmt->execute();
		$stmt->bind_result($id,$device_id,$value,$timestamp);
		
		$result = array();
		while($stmt->fetch()){
			$result = array(
				"id"=>$id,
				"device_id"=>$device_id,
				"value"=>$value,
				"timestamp"=>$timestamp
			);
		}
		
		return $result;
	}
	
	public function add(Array $array){
		$this->device_id = $array['device_id'];
		$this->value = $array['value'];
			
		$stmt = $this->mysqli->prepare("INSERT INTO `humidity`(`device_id`,`value`) VALUES (?,?)");
		$stmt->bind_param("ss",$this->device_id,$this->value);
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}

	}
	
	public function delete(Int $id){
		$this->id = $id;
		
		$stmt = $this->mysqli->prepare("DELETE FROM `humidity` WHERE `id`=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}
	}
	
	 public function update(Array $array){
	 	$this->id = $array['id'];
		$this->device_id = $array['device_id'];
		$this->value = $array['value'];
		
		$stmt = $this->mysqli->prepare("UPDATE `humidity` SET `device_id`=?,`value`=?  WHERE `id`=? LIMIT 1");
		$stmt->bind_param("ssi",$this->device_id,$this->value,$this->id);
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}
	 }
	 
	 public function getLastFifty(String $device_id){
	 	$this->device_id = $device_id;
		
		$stmt = $this->mysqli->prepare("SELECT * FROM `humidity` WHERE device_id=? ORDER BY `id` DESC LIMIT 50");
		$stmt->bind_param("i",$this->device_id);
		$stmt->execute();
		$stmt->bind_result($id,$device_id,$value,$timestamp);
		
		$array_list = array();
		
		while($stmt->fetch()){
			$array = array(
				"id"=>$id,
				"device_id"=>$device_id,
				"value"=>$value,
				"timestamp"=>$timestamp
			);
			$array_list[] = $array;
		}
		
		return $array_list;
	 }


}

?>