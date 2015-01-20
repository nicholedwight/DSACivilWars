<?php 

class Database
{
  /*
   * Database properties
   */
  private $server   = 'localhost';
  private $username = 'root';
  private $password = 'root';
  private $database = 'civil_war';
  public $pdo;
  public static $instance;

  /**
   * Static method used to instantiate singleton
   * @return [object] Database object
   */
  public static function getInstance()
  {
      if (!isset($instance)) {
          Database::$instance = new Database();
      }
      return Database::$instance;
  }

  /**
   * Connect to DB when class is instantiated
   */
  private function __construct() 
  {
      $this->connect();
  }

  /**
   * Connects to the database
   */
  private function connect()
  {   
      // Assign dsn string
      $dsn = 'mysql:host=' . $this->server . ';dbname=' . $this->database;

      try { 
          // Assign connection to $pdo
          $pdo = new PDO($dsn, $this->username, $this->password);
      } catch (PDOException $e) { 
          throw new pdoDbException($e); 
      } 

      // $pdo inside the method is added to the classes parameter pdo
      $this->pdo = $pdo;

  }

  /**
   * Queries database for the argument $sql
   * @param  string $sql
   * @return Sql Query $statement
   */
  public function query($sql)
  {   
      // Prepare SQL query
      $statement = $this->pdo->prepare($sql);

      // return mysql query array
      return $statement;
  }

}