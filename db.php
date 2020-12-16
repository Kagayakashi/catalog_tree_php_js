<?php

class Database {
    
    private $host;
    private $user;
    private $pass;
    private $db;
    
    public function __construct($params){
        $this->host = $params['host'];
        $this->user = $params['user'];
        $this->pass = $params['pass'];
        $this->db   = $params['db'];
    }
    
    // Добавить элемент дерева в БД
    public function data_insert($user, $name, $details, $parent_id = 'null'){
        $connection = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($connection->connect_error) {
            die("Connection failed: ".$connection->connect_error);
        }
        
        $sql = 'insert into tree (S_NAME, S_DETAILS, I_PARENT_ID, I_USER)
        values ("'.$name.'", "'.$details.'", '.$parent_id.', '.$user.')';
        
        if($connection->query($sql) === TRUE) {
            $res = true;
        }
        else {
            $res = false;
        }
        
        $connection->close();
        return $res;
    }
    
    // Изменить элемент дерева в БД
    public function data_update($id, $name, $details){
        $connection = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($connection->connect_error) {
            die("Connection failed: ".$connection->connect_error);
        }
        
        $sql = 'update tree set S_NAME = "'.$name.'", S_DETAILS = "'.$details.'" where I_ID = '.$id;
        
        if($connection->query($sql) === TRUE) {
            $res = true;
        }
        else {
            $res = false;
        }
        
        $connection->close();
        return $res;
    }
    
    // Выбрать элементы дерева из БД
    public function data_select($user, $parent_id = 0){
        $connection = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($connection->connect_error) {
            die("Connection failed: ".$connection->connect_error);
        }
        
        $sql = 'select I_ID, S_NAME, S_DETAILS, I_PARENT_ID from tree where I_USER = '.$user.' and I_PARENT_ID = '.$parent_id;
        
        $result = $connection->query($sql);
        
        if($result->num_rows > 0) {
            $res = $result;
        }
        else {
            $res = false;
        }
        
        $connection->close();
        return $res;
    }
    
    // Удалить элемент дерева из БД
    public function data_delete($id){
        $connection = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($connection->connect_error) {
            die("Connection failed: ".$connection->connect_error);
        }
        
        $sql = 'delete from tree where I_ID = '.$id;
        
        if($connection->query($sql) === TRUE) {
            $res = true;
        }
        else {
            $res = false;
        }
        
        $connection->close();
        return $res;
    }
    
    // Регистрация пользователя в БД
    public function user_insert($username, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $connection = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($connection->connect_error) {
            die("Connection failed: ".$connection->connect_error);
        }
        
        $sql = 'insert into users (S_USERNAME, S_PASSWORD)
        values ("'.$username.'", "'.$hash.'")';
        
        if($connection->query($sql) === TRUE) {
            $res = true;
        }
        else {
            $res = false;
        }
        
        $connection->close();
        return $res;
    }
    
    // Логин пользователя в БД
    public function user_select($username, $password) {
        $connection = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($connection->connect_error) {
            die("Connection failed: ".$connection->connect_error);
        }
        
        $sql = 'select I_ID, S_PASSWORD from users where S_USERNAME="'.$username.'"';
        
        $result = $connection->query($sql);
        
        if($result->num_rows > 0) {
            while($data = $result->fetch_assoc()) {
                $res = password_verify($password, $data['S_PASSWORD']) ? $data['I_ID'] : false;
            }
        }
        else {
            $res = false;
        }
        
        $connection->close();
        return $res;
    }
}