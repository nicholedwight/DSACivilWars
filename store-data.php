<?php
  require './database/Database.php';
  require './models/battles-model.php';

  $Db = Database::getInstance();
  $battles = new Battles($Db);

  $json = file_get_contents('./data/battles-data.json');

  $jsonArray = json_decode($json, true);

  foreach($jsonArray as $jsonItem) {
    $battles->insertBattle(
      $jsonItem['name'], 
      $jsonItem['date'],
      $jsonItem['location'],
      $jsonItem['lat'],
      $jsonItem['lng'],
      $jsonItem['outcome']
    );
  }
?>