<?php
function connectToDatabase() {
  if ($_SERVER['SERVER_NAME'] == 'civilwar.dev') {
    $db = new mysqli('localhost', 'root', 'root', 'civil_war');
  }
  else {
    $db = new mysqli('mysql5.cems.uwe.ac.uk', 'fet13000673', '8LYn8K', 'fet13000673');
  }
  if ($db->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
  }
  else return $db;
}

function getAllBattleInfo($battle_id) {
  $db = connectToDatabase();
  $query = "SELECT Battles.name, Battles.date, Battles.location, Battles.outcome, NotablePersons.name, Factions.name
  FROM Battles
  INNER JOIN Battles_has_NotablePersons
  ON Battles.id = Battles_has_NotablePersons.Battles_id
  INNER JOIN NotablePersons
  ON Battles_has_NotablePersons.NotablePersons_id = NotablePersons.id
  INNER JOIN Factions
  ON NotablePersons.Factions_id = Factions.id
  WHERE Battles.id $battle_id";
  $rows = array();
  $result = mysqli_query($db, $query);
  if ($result) {
    while(($row = mysqli_fetch_array($result))) {
      $rows[] = $row;
    }
    return $rows;
  }
}

function getBattles() {
  $db = connectToDatabase();
  $query = "SELECT * FROM Battles";
  $rows = array();
  $result = mysqli_query($db, $query);
  while(($row = mysqli_fetch_array($result))) {
    $rows[] = $row;
  }
  return $rows;
}


?>
