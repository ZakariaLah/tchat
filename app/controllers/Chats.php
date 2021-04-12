<?php
  class Chats extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        header('location: '. URLROOT . '/users/login');
      }
      $this->cModel = $this->model('Chat');
      $this->uModel = $this->model('User');
      
    }

    public function index(){
      $msg = $this->cModel->getMessages();
      $connected = $this->uModel->listConnected($_SESSION['user_id']);
      if(!is_null($connected)){
        $data = [
          'messages' => $msg,
          'users' => $connected
        ];
        $this->view('chat/index', $data);
      }else {
        $data = [
          'messages' => $msg,
          'users' => []
        ];
        $this->view('chat/index', $data);
      }
    }

    public function send(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $userId = $_SESSION['user_id'];
        $msg = $_POST['msg'];
        if($this->cModel->sendMessage($userId,$msg)){
          $msgs = $this->cModel->getMessages();
          $data = [
            'messages' => $msgs
          ];
          $this->view('chat/index', $data);
        }
      }
    }

  }