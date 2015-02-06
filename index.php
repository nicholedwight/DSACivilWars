<?php

session_start();

require './database/Database.php';
require './models/battles-model.php';

$Db = Database::getInstance();
$battles = new Battles($Db);

require './controllers/MapController.php';

$mapController = new Controller\Map($battles);

if(isset($_GET['page'])) {
  $page = $_GET['page'];
}

else {
  $page = 'map';
}

// If JSON is requested send data as JSON.
if(isset($_GET['json'])) {
  $resource = $_GET['json'];

  switch($resource) {
    case 'battles':
      $mapController->battlesDataAsJSON();
    break;
  }
}

// If no JSON resource is requested.
// serve HTML for application pages or 404 page.
if(empty($_GET['json'])) {
  switch($page) {
    case 'map':
      $mapController->mapHomePage();
    break;
    default:
      $mapController->pageNotFound();
    die();
  }
}
