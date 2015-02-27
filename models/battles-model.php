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
    $stmt = $this->db->query("SELECT * FROM Battles");

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

  public function getBattleByName($name)
  {
    $stmt = $this->db->query("SELECT * from Battles WHERE Battles.name = :name");

    $stmt->bindParam(':name', $name);
    $stmt->execute();

    $battle = array();

    while($row = $stmt->fetch()) {
      $battle = $row;
    }

    return $battle;

  }

  public function getBattleById($battleId)
  {
    $stmt = $this->db->query("SELECT * from Battles WHERE Battles.id = :id");

    $stmt->bindParam(':id', $battleId);
    $stmt->execute();

    $battle = array();

    while($row = $stmt->fetch()) {
      $battle = $row;
    }

    return $battle;

  }

  public function getFactionsByBattleId($battleId)
  {
    $stmt = $this->db->query("SELECT Factions.factionName, NotablePersons.notablePersonName FROM Battles
      INNER JOIN Battles_has_NotablePersons
      ON Battles.id = Battles_has_NotablePersons.Battles_id
      INNER JOIN NotablePersons
      ON Battles_has_NotablePersons.NotablePersons_id = NotablePersons.id
      INNER JOIN Factions
      ON NotablePersons.Factions_id = Factions.id
      WHERE Battles.id = :id"
    );

    $stmt->bindParam(':id', $battleId);
    $stmt->execute();

    $factionOne = array();
    $factionTwo = array();

    while($row = $stmt->fetch()) {
      if(isset($factionOne['factionName']) && $row['factionName'] !== $factionOne['factionName']) {
        $factionTwo['factionName'] = $row['factionName'];
        if(empty($factionTwo['notablePerson'])) {
          $factionTwo['notablePerson'] = $row['notablePersonName'];
        }
        else {
          $factionTwo['notablePersonTwo'] = $row['notablePersonName'];
        }
      }
      if(isset($factionOne['factionName']) && $row['factionName'] === $factionOne['factionName']) {
          $factionOne['notablePersonTwo'] = $row['notablePersonName'];
      }
      if(empty($factionOne['factionName'])) {
        $factionOne['factionName'] = $row['factionName'];
        $factionOne['notablePerson'] = $row['notablePersonName'];
      }
    }

    $factions = array($factionOne, $factionTwo);

    $battleFactions = array('factions'=>$factions);

    return $battleFactions;
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
