<?php

class Battles
{
  // Battle properties
  public $db;
  public $battles;
  
  // Assign parameter to argument to $db property
  public function __construct($db)
  {
    $this->db = $db;
  }

  /**
   * Queries for all data in battles table
   * @return [array]
   */
  public function getBattles()
  {
    // Query
    $stmt = $this->db->query("SELECT * FROM battles");

    // Executes query
    $stmt->execute();

    // Create an empty array for the battles
    $battles = array();

    // loop through $result
    while($row = $stmt->fetch()) {

      // data from battles is added to the array
      $battles[] = $row;

    } 
    // Return Array of rows
    return $battles;
  }

  // Insert Battle
  public function insertBattle($name, $date, $location, $lat, $lng, $outcome)
  { 
    // Query 
    $stmt = $this->db->query("INSERT INTO battles VALUES ( DEFAULT, :name, :date, :location, :latitude, :longitude, :outcome)");

    // Execute query
    $stmt->execute(array(
      ':name'=>$name, 
      ':date'=>$date,
      ':location'=>$location,
      ':latitude'=>$lat,
      ':longitude'=>$lng,
      ':outcome'=>$outcome
    ));
  }
}