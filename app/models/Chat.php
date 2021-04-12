<?php
  class Chat {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getMessages()
    {
      $this->db->query('SELECT *,
                        chat.id as chatID,
                        users.id as userID
                        FROM chat
                        INNER JOIN users
                        on chat.userId = users.id 
                        ORDER BY chat.createdAt DESC
                        ');
      $resutls = $this->db->resultSet();
      return $resutls;
    }

    public function sendMessage($userId,$msg)
    {
      $this->db->query('INSERT INTO chat (userId, message) VALUES(:user,:msg)');
      $this->db->bind(':user', $userId);
      $this->db->bind(':msg', $msg);

      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }
  }