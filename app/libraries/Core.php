<?php
  /* 
   * creates url and loads controller
   * url format /controller/method/param
   */
  class Core{
    protected $controller = 'Users';
    protected $method = 'index';
    protected $params = [];

    public function __construct(){
      if(isset($_GET['url'])){
        $url = $this->getUrl();
        // look in controllers for first array value
        if(file_exists('../app/controllers/'. ucwords($url[0]). '.php')){
          $this->controller = ucwords($url[0]);
          unset($url[0]);
        }
      }
      // require controller
      require_once '../app/controllers/'.$this->controller.'.php';
      // instantiate controller class
      $this->controller = new $this->controller;

      // second url value
      if(isset($url[1])){
        // check method in controller
        if(method_exists($this->controller,$url[1])){
          $this->method = $url[1];
          unset($url[1]);
        }
      }
      if(isset($url)){
      $this->params = $url ? array_values($url) : [];
      }

      // call a callback with array of params
      call_user_func_array([$this->controller,$this->method],$this->params);
    }

    public function getUrl(){
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode( '/', $url);
        return $url;
    }

  }
   