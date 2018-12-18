<?php

class User {

	private $mysqli;
	
	public $id;
	public $first_name;
	public $last_name;
	public $username;
	public $password;
	public $timestamp_created;
	
	function __construct($mysqli){
		$this->mysqli = $mysqli;
	}

	
	public function getAll(){
		$ar = array();
		$query = "SELECT * FROM `user` ORDER BY `first_name` ASC";

		if($result = $this->mysqli->query($query)){
			while($u = $result->fetch_array()){
				$id = $u['id'];
				$first_name = $u['first_name'];
				$last_name = $u['last_name'];
				$username = $u['username'];
				$timestamp_created = $u['timestamp_created'];

				$array = array(
					"id"=>$id,
					"first_name"=>$first_name,
					"last_name"=>$last_name,
					"username"=>$username,
					"timestamp_created"=>$timestamp_created
				);

				$ar[] = $array;
			}
		}

		return $ar;

	}

	public function get(Int $id){
		$this->id = $id;
		
		$stmt = $this->mysqli->prepare("SELECT id,first_name,last_name,username,timestamp_created FROM `user` WHERE id=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		$stmt->execute();
		$stmt->bind_result($id,$first_name,$last_name,$username,$timestamp_created);
		
		$array = array();
		
		while($stmt->fetch()){
			$array = array(
				"id"=>$id,
				"first_name"=>$first_name,
				"last_name"=>$last_name,
				"username"=>$username,
				"timestamp_created"=>$timestamp_created
			);
		}
		
		return $array;
	}
	
	public function getByUsername(String $username){
		$this->username = $username;
		
		$stmt = $this->mysqli->prepare("SELECT * FROM `user` WHERE username=? LIMIT 1");
		$stmt->bind_param("s",$this->username);
		$stmt->execute();
		$stmt->bind_result($id,$first_name,$last_name,$username,$password,$timestamp_created);
		
		$array = array();
		
		while($stmt->fetch()){
			$array = array(
				"id"=>$id,
				"first_name"=>$first_name,
				"last_name"=>$last_name,
				"username"=>$username,
				"password"=>$password,
				"timestamp_created"=>$timestamp_created
			);
		}
		
		if($array == Array()){
			return False;
		} else {
			return $array;
		}
	}
	
	public function delete(Int $id){
		$this->id = $id;
		$stmt = $this->mysqli->prepare("DELETE FROM `user` WHERE `id`=? LIMIT 1");
		$stmt->bind_param("i",$this->id);
		
		if($stmt->execute()){
			return True;
		} else {
			return False;
		}
	}	
	
	public function add(Array $array){
        $this->first_name = $array['first_name'];
		$this->last_name = $array['last_name'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        
        $hash_password = password_hash($this->password,PASSWORD_DEFAULT);

        $stmt = $this->mysqli->prepare("INSERT INTO `user`(`first_name`,`last_name`,`username`,`password`) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss",$this->first_name,$this->last_name,$this->username,$hash_password);

        if($stmt->execute()){
            return True;
        } else {
            return False;
        }
    }
	
	public function update(Array $array){
        $this->id = $array['id'];
        $this->first_name = $array['first_name'];
		$this->last_name =  $array['last_name'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        
        $hash_password = password_hash($this->password,PASSWORD_DEFAULT);

        $stmt = $this->mysqli->prepare("UPDATE `user` SET `first_name`=?, `last_name`=?, `username`=? WHERE id=? LIMIT 1");
        $stmt->bind_param("sssi",$this->first_name,$this->last_name,$this->username,$this->id);

        if($stmt->execute()){
            
            if(!empty($this->password)){

                $stmt = $this->mysqli->prepare("UPDATE `user` SET `password`=? WHERE id=? LIMIT 1");
                $stmt->bind_param("si",$hash_password,$this->id);

                if($stmt->execute()){
                    return True;
                } else {
                    return False;
                }

            } else {
                return True;
            }
            
        } else {
            return False;
        }
    }
	
	public function usernameExists(String $username){
        $this->username = $username;
        $result = $this->getByUsername($this->username);
        if(empty($result)){
            return False;
        } else {
            return True;
        }
    }
	
	public function verifyCredentials(Array $array){
        $this->username = $array['username'];
        $this->password = $array['password'];

        $result = $this->getByUsername($this->username);

        if(empty($result)){
            return "User not registered";
        } else {
			if($result == False){
				return "User not registered";
			} else {
				$hash_password = $result['password'];

				if(password_verify($this->password, $hash_password)){
					return True;
				} else {
					return "Password is Incorrect";
				}
	
			}
        }

    }

}

?>
