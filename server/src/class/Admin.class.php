<?php

class Admin {

    private $mysqli;

    public $id;
    public $name;
    public $username;
    public $password;
    public $timestamp_created;
    public $timestamp_modified;

    function __construct($mysqli){
        $this->mysqli = $mysqli;
    }


    public function getAll(){
        $query = "SELECT * FROM `administrator` ORDER BY `name` ASC";

        $admin_array = array();

        if($result = $this->mysqli->query($query)){
            while($a = $result->fetch_array()){
                $array = array(
                    "id"=>$a['id'],
                    "name"=>$a['name'],
                    "username"=>$a['username'],
                    "timestamp_created"=>$a['timestamp_created'],
                    "timestamp_modified"=>$a['timestamp_modified']                    
                );

                $admin_array[] = $array;
            }
        }

        return $admin_array;
    }

    public function get(Int $id){
        $this->id = $id;

        $stmt = $this->mysqli->prepare("SELECT * FROM `administrator` WHERE id=? LIMIT 1");
        $stmt->bind_param("i",$this->id);
        $stmt->execute();
        $stmt->bind_result($id,$name,$username,$password,$timestamp_created,$timestamp_modified);

        $admin_info = array();

        while($stmt->fetch()){
            $admin_info = array(
                "id"=>$id,
                "name"=>$name,
                "username"=>$username,
                "password"=>$password,
                "timestamp_created"=>$timestamp_created,
                "timestamp_modified"=>$timestamp_modified
            );
        }

        return $admin_info;
    }

    public function getByUsername(String $username){
        $this->username = $username;

        $stmt = $this->mysqli->prepare("SELECT * FROM `administrator` WHERE username=? LIMIT 1");
        $stmt->bind_param("s",$this->username);
        $stmt->execute();
        $stmt->bind_result($id,$name,$username,$password,$timestamp_created,$timestamp_modified);

        $admin_info = array();

        while($stmt->fetch()){
            $admin_info = array(
                "id"=>$id,
                "name"=>$name,
                "username"=>$username,
                "password"=>$password,
                "timestamp_created"=>$timestamp_created,
                "timestamp_modified"=>$timestamp_modified
            );
        }

        return $admin_info;
    }

    public function delete(Int $id){
        $this->id = $id;

        $stmt = $this->mysqli->prepare("DELETE FROM `administrator` WHERE id=? LIMIT 1");
        $stmt->bind_param("i",$this->id);

        if($stmt->execute()){
            return True;
        } else {
            return False;
        }
    }


    public function add(Array $admin_info){
        $this->name = $admin_info['name'];
        $this->username = $admin_info['username'];
        $this->password = $admin_info['password'];
        $current_time = date("Y-m-d H:i:s");
        
        $hash_password = password_hash($this->password,PASSWORD_DEFAULT);

        $stmt = $this->mysqli->prepare("INSERT INTO `administrator`(`name`,`username`,`password`,`timestamp_created`) VALUES(?,?,?,?)");
        $stmt->bind_param("sss",$this->name,$this->username,$hash_password,$current_time);

        if($stmt->execute()){
            return True;
        } else {
            return False;
        }
    }

    public function update(Array $admin_info){
        $this->id = $admin_info['id'];
        $this->name = $admin_info['name'];
        $this->username = $admin_info['username'];
        $this->password = $admin_info['password'];
        
        $hash_password = password_hash($this->password,PASSWORD_DEFAULT);

        $stmt = $this->mysqli->prepare("UPDATE `administrator` SET `name`=?, `username`=? WHERE id=? LIMIT 1");
        $stmt->bind_param("ssi",$this->name,$this->username,$this->id);

        if($stmt->execute()){
            
            if(!empty($this->password)){

                $stmt = $this->mysqli->prepare("UPDATE `administrator` SET `password`=? WHERE id=? LIMIT 1");
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
            return False;
        } else {
            $hash_password = $result['password'];

            if(password_verify($this->password, $hash_password)){
                return True;
            } else {
                return False;
            }
        }

    }

}

?>