<?php

class AirQuality {
	
	private $mysqli;
	
	public $id;
	public $device_id;
	public $value;
	public $description;
	public $month;
	public $day;
	public $year;
	public $time;

	function __construct($mysqli){
		$this->mysqli = $mysqli;
	}

	public function get(Int $id){
		$this->id = $id;
		$stmt = $this->mysqli->prepare("SELECT * FROM `air_quality` WHERE `id`=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		$stmt->execute();
		$stmt->bind_result($id,$device_id,$value,$description,$month,$day,$year,$time);
		
		$result = array();
		while($stmt->fetch()){
			$result = array(
				"id"=>$id,
				"device_id"=>$device_id,
				"value"=>$value,
				"description"=>$description,
				"month"=>$month,
				"day"=>$day,
				"year"=>$year,
				"time"=>$time
			);
		}
		
		return $result;
	}
	
	public function add(Array $array){
		$this->device_id = $array['device_id'];
		$this->value = $array['value'];
		$this->description = $array['description'];
		
		$this->month = date("M");
		$this->day = date("d");
		$this->year = date("Y");
		$this->time = date("H:i:s");
		
		$stmt = $this->mysqli->prepare("INSERT INTO `air_quality`(`device_id`,`value`,`description`,`month`,`day`,`year`,`time`) VALUES (?,?,?,?,?,?,?)");
		$stmt->bind_param("issssss",$this->device_id,$this->value,$this->description,$this->month,$this->day,$this->year,$this->time);
		
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
		$this->month = $array['month'];
		$this->day = $array['day'];
		$this->year = $array['year'];
		$this->time = $array['time'];
		
		$stmt = $this->mysqli->prepare("UPDATE `air_quality` SET `device_id`=?,`value`=?,`description`=?,`month`=?,`day`=?,`year`=?,`time`=?  WHERE `id`=? LIMIT 1");
		$stmt->bind_param("ssssssi",$this->device_id,$this->value,$this->description=?,$this->month,$this->day,$this->year,$this->time,$this->id);
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}
	 }
	 
	 public function getLastFifty(Int $device_id){
	 	$this->device_id = $device_id;
		
		$stmt = $this->mysqli->prepare("SELECT * FROM `air_quality` WHERE id=? ORDER BY `id` DESC LIMIT 50");
		$stmt->bind_param("i",$this->device_id);
		$stmt->execute();
		$stmt->bind_result($id,$device_id,$value,$description,$month,$day,$year,$time);
		
		$array_list = array();
		
		while($stmt->fetch()){
			$array = array(
				"id"=>$id,
				"device_id"=>$device_id,
				"value"=>$value,
				"description"=>$description,
				"month"=>$month,
				"day"=>$day,
				"year"=>$year,
				"time"=>$time
			);
			$array_list[] = $array;
		}
		
		return $array_list;
	 }


}

?>
