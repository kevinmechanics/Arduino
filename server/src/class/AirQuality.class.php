<?php

class AirQuality {
	
	private $mysqli;
	
	public $id;
	public $device_id;
	public $value;
	public $description;
	public $timestamp;

	function __construct($mysqli){
		$this->mysqli = $mysqli;
	}

	public function get(Int $id){
		$this->id = $id;
		$stmt = $this->mysqli->prepare("SELECT * FROM `air_quality` WHERE `id`=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		$stmt->execute();
		$stmt->bind_result($id,$device_id,$value,$description,$timestamp);
		
		$result = array();
		while($stmt->fetch()){
			$result = array(
				"id"=>$id,
				"device_id"=>$device_id,
				"value"=>$value,
				"description"=>$description,
				"timestamp"=>$timestamp
			);
		}
		
		return $result;
	}
	
	public function add(Array $array){
		$this->device_id = $array['device_id'];
		$this->value = $array['value'];
		$this->description = $array['description'];
		
		$stmt = $this->mysqli->prepare("INSERT INTO `air_quality`(`device_id`,`value`,`description`) VALUES (?,?,?)");
		$stmt->bind_param("sss",$this->device_id,$this->value,$this->description);
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}

	}
	
	public function delete(Int $id){
		$this->id = $id;
		
		$stmt = $this->mysqli->prepare("DELETE FROM `air_quality` WHERE `id`=? LIMIT 1");
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
		$this->description = $array['description'];
		
		$stmt = $this->mysqli->prepare("UPDATE `air_quality` SET `device_id`=?,`value`=?,`description`=?  WHERE `id`=? LIMIT 1");
		$stmt->bind_param("sssi",$this->device_id,$this->value,$this->description,$this->id);
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}
	 }
	 
	 public function getLastFifty(String $device_id){
	 	$this->device_id = $device_id;
		
		$stmt = $this->mysqli->prepare("SELECT * FROM `air_quality` WHERE device_id=? ORDER BY `id` DESC LIMIT 50");
		$stmt->bind_param("i",$this->device_id);
		$stmt->execute();
		$stmt->bind_result($id,$device_id,$value,$description,$timestamp);
		
		$array_list = array();
		
		while($stmt->fetch()){
			$array = array(
				"id"=>$id,
				"device_id"=>$device_id,
				"value"=>$value,
				"description"=>$description,
				"timestamp"=>$timestamp
			);
			$array_list[] = $array;
		}
		
		return $array_list;
	 }


}

?>