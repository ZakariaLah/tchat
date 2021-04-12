<?php
  session_start();
  // load config file 
  require_once('config/config.php');
  // auto load libraries
  spl_autoload_register(function($className){
    require_once('libraries/'.$className.'.php');
  });