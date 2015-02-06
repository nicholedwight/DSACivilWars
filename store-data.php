<?php
  require './database/Database.php';
  require './models/battles-model.php';

  $Db = Database::getInstance();
  $battles = new Battles($Db);

  $json = file_get_contents('./data/battles-data.json');

  $jsonArray = json_decode($json, true);

  foreach($jsonArray as $jsonItem) {
    $unixtime = strtotime($jsonItem['date']);
    $date = date("Y-m-d", $unixtime);

    $battles->insertBattle(
      $jsonItem['name'], 
      $date,
      $jsonItem['location'],
      $jsonItem['lat'],
      $jsonItem['lng'],
      $jsonItem['outcome']
    );
  }
?>