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
	
	public function getAll(){
		$array = array();

		$query = "SELECT * FROM `device` ORDER BY `location` ASC";

		if($result = $this->mysqli->query($query)){
			while($res = $result->fetch_array()){
				$ar = array(
					"id"=>$res['id'],
					"device_id"=>$res['device_id'],
					"location"=>$res['location'],
					"city"=>$res['city'],
					"mobile_number"=>$res['mobile_number'],
					"timestamp_created"=>$res['timestamp_created'],
					"timestamp_modified"=>$res['timestamp_modified']
				);
				$array[] = $ar;
			}
		}

		return $array;
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
	
	public function update(Array $array){
		$this->id = $array['id'];
		$this->device_id = $array['device_id'];
		$this->location = $array['location'];
		$this->city = $array['city'];
		$this->mobile_number = $array['mobile_number'];
		
		$stmt = $this->mysqli->prepare("UPDATE `device` SET `device_id`=?,`location`=?,`city`=?,`mobile_number`=? WHERE `id`=? LIMIT 1");
		$stmt->bind_param("sssss",$this->device_id,$this->location,$this->city,$this->mobile_number,$this->id);
		$stmt->execute();
		return True;
		
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
		$stmt->bind_param("ssss",$this->device_id,$this->location,$this->city,$this->mobile_number);
		
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