<?php

/**
 * Database file for dealing with connections to database
 *
 * Contains connection information for database and functions
 * for connecting to the database by using PDO a lightweight,
 * consistent interface for accessing databases in PHP.
 */

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
   * Magic construct method for connecting to the database
   * upon instantiation.
   */
  private function __construct()
  {
      $this->connect();
  }

  /**
   * Function which deals with connecting to the database through PDO.
   */
  private function connect()
  {
      // Assign dsn string
      $dsn = 'mysql:host=' . $this->server . ';dbname=' . $this->database;

      try {
          // Assign connection to $pdo
          $pdo = new PDO($dsn, $this->username, $this->password);
      } catch (PDOException $e) {
          throw new PDOException( $Exception->getMessage( ) , $Exception->getCode( ) );
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
