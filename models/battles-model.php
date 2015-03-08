<?php

/**
 * Battles model which contains methods for returning battle data
 *
 * File contains methods for querying database and returning
 * data to then be output to the page.
 */

class Battles
{
  // Battle properties
  public $db;
  public $battles;

  /**
   * Magic method for assigning the database argument as a property to the battles class
   * @param object $db Database object
   */
  public function __construct($db)
  {
    $this->db = $db;
  }

  /**
   * Function that queries for all data in battles table
   * @return array $battles Array of all the battles in the battles table
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

  /**
   * Function for getting a battle from the database
   * by querying where name is equal to the parameter and
   * then adding to array and returning it.
   * @param  string $name Name of battle to retrieve from database
   * @return array $battle Returns array containing data for chosen battle
   */
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

  /**
   * Function for getting a battle from the database
   * by querying where the id is equal to the parameter and
   * then adding to array and returning it.
   * @param  integer $battleId ID of battle to query
   * @return array $battleFactions Returns array containing data for chosen battle
   */
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

  /**
     * Function for getting factions of a specific Battle ID
     * @param integer $battleId ID of the battle to query
     * @return array $battle Returns array containing faction data from the battle
     */
  public function getFactionsByBattleId($battleId)
  {
    $stmt = $this->db->query("SELECT Factions.factionName, NotablePersons.notablePersonName, NotablePersons.imageURL FROM Battles
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

    $factions = array();

    while($row = $stmt->fetch()) {
      // Used to see if faction array has already been created
      $doesFactionExist = false;

      foreach ($factions as &$faction) {
        // If faction array has already been created
        // add notable persons to it
        if($row['factionName'] == $faction['factionName']) {
          array_push($faction['notablePersons'],
            array(
              "name" => $row['notablePersonName'],
              "imageURL" => $row['imageURL']
              )
            );
          $doesFactionExist = true;
        }
      }
      // If faction is new, create an array for it
      if($doesFactionExist === false) {
        array_push($factions, array(
          "factionName" => $row['factionName'],
          "notablePersons" => array(
            array(
              "name" => $row['notablePersonName'],
              "imageURL" => $row['imageURL']
              )
            )
          )
        );
      }
    }
  return $factions;
}

  /**
   * Function for inserting Battles into the database
   * @param  string $name Name of the battle
   * @param  date $date Date of the battle
   * @param  string $location Town or city name of the battle location
   * @param  float $lat Latitude of the location of the battle
   * @param  float $lng Longtitude of the location of the battle
   * @param  string $outcome Outcome of the battle
   */
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

  public function getAllData() {
    $stmt = $this->db->query("SELECT * FROM Battles
        INNER JOIN Battles_has_NotablePersons
        ON Battles.id = Battles_has_NotablePersons.Battles_id
        INNER JOIN NotablePersons
        ON Battles_has_NotablePersons.NotablePersons_id = NotablePersons.id
        INNER JOIN Factions
        ON NotablePersons.Factions_id = Factions.id");

    $stmt->execute();

    $allData = array();

    while($row = $stmt->fetch()) {
      $doesBattleExist = false;
      $doesFactionExist = false;

      foreach ($allData as &$data) {
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
          if($row['name'] == $data['battleName']) {
            array_push(
              $data['factions'], array(
                "factionName" => $row['factionName'],
                "notablePersons" => array(
                  array(
                    "name" => $row['notablePersonName'],
                    "imageURL" => $row['imageURL']
                  )
                )
              )
            );
          $doesBattleExist = true;
        }
      }

    //   foreach ($allData as &$data) {
    //     // If faction array has already been created
    //     // add notable persons to it
    //       if($row['factionName'] == $data['factionName']) {
    //       array_push($data['factions'], array (
    //       "notablePersons" =>
    //         array(
    //           "name" => $row['notablePersonName'],
    //           "imageURL" => $row['imageURL']
    //           )
    //
    //         )
    //         );
    //       // $doesBattleExist = true;
    //       $doesFactionExist = true;
    //     }
    //
    // }

      if($doesBattleExist === false) {
        array_push($allData, array(
          "battleName" => $row['name'],
          "location" => $row['location'],
          "outcome" => $row['outcome'],
          "battleDescription" => $row['description'],
          "factions" => array(
              "factionName" => $row['factionName'],
              "notablePersons" => array(
                array(
                  "name" => $row['notablePersonName'],
                  "imageURL" => $row['imageURL']
                  )
                )
              )
            )
          );
        }
    }
    return $allData;
  }

}



// while($row = $stmt->fetch()) {
//   $doesBattleExist = false;
//
//   foreach ($allData as &$data) {
//     if($row['name'] == $data['battleName']) {
//       array_push($data['factions'],
//         array(
//           "factionName" => $row['factionName'],
//           "notablePersons" => array(
//             array(
//               "name" => $row['notablePersonName'],
//               "imageURL" => $row['imageURL']
//               )
//             )
//           )
//         );
//       $doesBattleExist = true;
//     }
//
//     if($doesBattleExist === false) {
//       array_push($allData, array(
//         "battleName" => $row['name'],
//         "factions" => array(
//           array(
//             "factionName" => $row['factionName'],
//             "notablePersons" => array(
//               array(
//                 "name" => $row['notablePersonName'],
//                 "imageURL" => $row['imageURL']
//                 )
//               )
//             )
//           )
//         )
//       );
//     }
//   }
// }
