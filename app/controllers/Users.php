<?php
  class Users extends Controller{
    public function __construct(){
      $this->uModel = $this->model('User');
    }
    public function index(){
      $this->view('users/index', ['title' => 'Welcome']);
    }
    public function register(){
      if ($_SERVER['REQUEST_METHOD']=='POST') {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data =[
          'name' => trim($_POST['name']),
          'password' => trim($_POST['pwd']),
          'confirmPassword' => trim($_POST['confirm_pwd']),
          'name_err' => '',
          'password_err' => '',
          'confirmPassword_err' => ''
        ];

        //data validation
        if (empty($data['name'])) {
          $data['name_err'] ='Please enter a username';
        }else {
          if ($this->uModel->findUserByUsername($data['name'])) {
            $data['name_err'] ='Username already taken';
          }
        }
        if (empty($data['password'])) {
          $data['password_err'] ='Please enter a password';
        }elseif (strlen($data['password']) < 6) {
          $data['password_err'] ='Password must be at least 6 characters';
        }
        if (empty($data['confirmPassword'])) {
          $data['confirmPassword_err'] ='Please confirm password';
        }elseif ($data['password'] != $data['confirmPassword'] ) {
          $data['confirmPassword_err'] ='Passwords do not match';
        }

        if (empty($data['name_err']) && empty($data['password_err']) && empty($data['confirmPassword_err'])) {
          $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

          if ($this->uModel->register($data)) {
            header('location: '. URLROOT . '/users/login');
          }else {
            die('something went wrong');
          }
        }else {
          $this->view('users/register',$data);
        }
        
      }else {
        $data =[
          'name' => '',
          'password' => '',
          'confirmPassword' => '',
          'name_err' => '',
          'password_err' => '',
          'confirmPassword_err' => ''
        ];
      }
      $this->view('users/register', $data);
    }

    public function login(){
      if ($_SERVER['REQUEST_METHOD']=='POST') {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data =[
          'name' => trim($_POST['name']),
          'password' => trim($_POST['pwd']),
          'name_err' => '',
          'password_err' => ''
        ];

        //data validation
        if (empty($data['name'])) {
          $data['name_err'] ='Please enter a username';
        }
        if (empty($data['password'])) {
          $data['password_err'] ='Please enter a password';
        }

        if ($this->uModel->findUserByUsername($data['name'])) {
          
        }else {
          $data['name_err'] ='not found';
        }

        if (empty($data['name_err']) && empty($data['password_err'])) {
          $conected = $this->uModel->login($data['name'],$data['password']);

          if ($conected) {
            $this->createUserSess($conected);
          }else {
            $data['password_err'] = 'incorrect password';
            $this->view('users/login',$data);
          }
        }else {
          $this->view('users/login',$data);
        }
        
      }else {
        $data =[
          'name' => '',
          'password' => '',
          'name_err' => '',
          'password_err' => ''
        ];
      }
      $this->view('users/login', $data);
    }

    public function createUserSess($user)
    {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_name'] = $user->name;
      header('location: '. URLROOT . '/chats/index');
    }

    public function logout()
    { 
      if($this->uModel->disconnected($_SESSION['user_name'])){
          unset($_SESSION['user_id']);
          unset($_SESSION['user_name']);
          session_destroy();
          header('location: '. URLROOT . '/users/login');
      }
    }
  } 