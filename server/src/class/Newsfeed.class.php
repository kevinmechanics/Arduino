<?php

class Newsfeed {

	private $mysqli;
	
	public $id;
	public $title;
	public $content;
	public $timestamp_created;
	
	function __construct($mysqli){
		$this->mysqli = $mysqli;
	}
	
	public function get(Int $id){
		$this->id = $id;
		
		$stmt = $this->mysqli->prepare("SELECT * FROM `newsfeed` WHERE `id`=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		$stmt->execute();
		$stmt->bind_result($id,$title,$content,$timestamp_created);
		
		$array = array();
		
		while($stmt->fetch()){
			$array = array(
				"id"=>$id,
				"title"=>$title,
				"content"=>$content,
				"timestamp_created"=>$timestamp_created
			);
		}
		
		return $array;
	}
	
	public function add(Array $array){
		$this->title = $array["title"];
		$this->content = $array["content"];
		
		$stmt = $this->mysqli->prepare("INSERT INTO `newsfeed`(`title`,`content`) VALUES(?,?)");
		$stmt->bind_param("ss",$this->title,$this->content);
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}
	}
	
	public function delete(Int $id){
		$this->id = $id;
		
		$stmt = $this->mysqli->prepare("DELETE FROM `newsfeed` WHERE `id`=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}
	}
	
	public function update(Array $array){
		$this->id = $array["id"];
		$this-title = $array["title"];
		$this->content = $array["content"];
		
		$stmt = $this->mysqli->prepare("UPDATE `newsfeed` SET `title`=?,`content`=? WHERE `id`=? LIMIT 1");
		$stmt->bind_param("ssi",$this->title,$this->content,$this->id);
		
		if($stmt->execute()){ 
			return True;
		} else {
			return False;
		}
	}

}

?>
