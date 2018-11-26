<?php

class Device {

	private $mysqli;
	
	public $id;
	public $device_id;
	public $location;
	public $city;
	public $mobile_number;
	public $timestamp_created;
	public $timestamp_modified;
	
	function __construct($mysqli){
		$this->mysqli = $mysqli;
	}
	
	public function get(Int $id){
		$this->id = $id;
		$stmt = $this->mysqli->prepare("SELECT * FROM `device` WHERE id=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		$stmt->execute();
		$stmt->bind_result($id,$device_id,$location,$city,$mobile_number,$timestamp_created,$timestamp_modified);
		
		$array = array();
		
		while($stmt->fetch()){
			$array = array(
				"id"=>$id,
				"device_id"=>$device_id,
				"location"=>$location,
				"city"=>$city,
				"mobile_number"=>$mobile_number,
				"timestamp_created"=>$timestamp_created,
				"timestamp_modified"=>$timestamp_modified
			);
		}
		
		return $array;
	}
	
	public function getByDeviceId(String $device_id){
		$this->device_id = $device_id;
		$stmt = $this->mysqli->prepare("SELECT * FROM `device` WHERE `device_id`=? LIMIT 1");
		$stmt->bind_param("s",$this->device_id);
		$stmt->execute();
		$stmt->bind_result($id,$device_id,$location,$city,$mobile_number,$timestamp_created,$timestamp_modified);
		
		$array = array();
		
		while($stmt->fetch()){
			$array = array(
				"id"=>$id,
				"device_id"=>$device_id,
				"location"=>$location,
				"city"=>$city,
				"mobile_number"=>$mobile_number,
				"timestamp_created"=>$timestamp_created,
				"timestamp_modified"=>$timestamp_modified
			);
		}
		
		return $array;
	}
	
	public function add(Array $array){
		$this->device_id = $array['device_id'];
		$this->location = $array['location'];
		$this->city = $array['city'];
		$this->mobile_number = $array['mobile_number'];
		
		$stmt = $this->mysqli->prepare("INSERT INTO `device`(`device_id`,`location`,`city`,`mobile_number`) VALUES(?,?,?,?)");
		$stmt->bind_param("ssss",$this->device_id,$this->location,$this->city,$this->mobile_number):
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}
	}
	
	public function delete(Int $id){
		$this->id = $id;
		$stmt = $this->mysqli->prepare("DELETE FROM `device` WHERE `id`=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		
		if($stmt->execute()){
			return True;
		} else {
			return  False;
		}
	}

}

?>
