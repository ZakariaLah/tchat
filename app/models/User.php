<?php 
  class User {
    private $db;

    public function __construct()
    {
      $this->db = new Database;
    }

    public function findUserByUsername( $username)
    {
      $this->db->query('SELECT * FROM users WHERE name = :username');
      $this->db->bind(':username', $username);
      $row = $this->db->single();

      if ($this->db->rowCount()>0) {
        return true;
      }else {
        return false;
      }
    }

    public function register($data)
    {
      $this->db->query('INSERT INTO users (name, password) VALUES(:name,:password)');
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':password', $data['password']);

      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }

    public function login($name , $password)
    {
      $this->db->query('SELECT * FROM users WHERE name = :username');
      $this->db->bind(':username', $name);
      $row = $this->db->single();
      $hashed_pwd = $row->password;
      if (password_verify($password, $hashed_pwd)) {
       if( $this->connected($name)){
        return $row;
       }
      }else {
        return false;
      }
    }

    public function connected($name)
    {
      $this->db->query('UPDATE users SET connected = 1 WHERE name = :name');
      $this->db->bind(':name', $name);
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }

    public function disconnected($name)
    {
      $this->db->query('UPDATE users SET connected = 0 WHERE name = :name');
      $this->db->bind(':name', $name);
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }

    public function listConnected($userId)
    {
      $this->db->query('SELECT users.name FROM users  
      WHERE connected = 1 && id != :userId');
      $this->db->bind(':userId', $userId);
      $row = $this->db->resultSet();
      if($row){
        return $row;
      }else {
        return null;
      }
    }
  }