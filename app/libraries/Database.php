<?php
  /*
   * PDO db class
   * connect to db
   * create prepared statement
   * bind values
   * return rows and results
   */
  class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pwd = DB_PASSWORD;
    private $dbName = DB_NAME;
    private $dbPort = DB_PORT;
    private $dbh;
    private $stmt;
    private $err;

    public function __construct(){
      // set dsn
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';port=' . $this->dbPort;
      $options = array(
        PDO::ATTR_PERSISTENT => true, 
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );
      //create pdo instance
      try {
        $this->dbh = new PDO($dsn, $this->user, $this->pwd, $options);
      } catch (PDOException $e) {
        $this->err = $e->getMessage();
        echo $this->err;  
      }
    }
    // prepare statement
    public function query($sql){
      $this->stmt = $this->dbh->prepare($sql);
    }
    //bind query
    public function bind($param, $value, $type = null){
      if(is_null($type)){
        switch (true) {
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;           
          default:
            $type = PDO::PARAM_STR;
        }
      }

      $this->stmt->bindValue($param, $value, $type);
    }
    //execute prepared stmt
    public function execute(){
      return $this->stmt->execute();
    }
    //get result set as array of objects
    public function resultSet(){
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    // get single result as object
    public function single(){
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    // get row count 
    public function rowCount(){
      return $this->stmt->rowCount();  
    }

  }