<?php
require './database/Database.php';
require './models/battles-model.php';
require './controllers/PageController.php';
require './controllers/ResourceController.php';

$Db = Database::getInstance();
$battles = new Battles($Db);

$PageController = new Controller\Page($battles);
$ResourceController = new Controller\Resource($battles);

if(isset($_GET['page'])) {
  $page = $_GET['page'];
}

if(isset($_GET['id'])) {
  $battleId = $_GET['id'];
}

else {
  $page = 'map';
}

// If JSON is requested send data as JSON.
if(isset($_GET['json'])) {
  $resource = $_GET['json'];

  header_remove(); 
  header("Content-Type:application/json");

  switch($resource) {
    case 'battles':
      $ResourceController->battlesDataAsJSON();
    break;
  }
}

// If RSS is requested send data as XML.
if(isset($_GET['rss'])) {
  if(isset($battleId)) {
    header_remove(); 
    header("Content-Type:text/xml");
    $ResourceController->renderRSSByBattleId($battleId);
  }
  else {
    echo 'No content found';
  }

}

// If no JSON resource is requested.
// serve HTML for application pages or 404 page.
if(empty($_GET['json']) && empty($_GET['rss'])) {

  header_remove(); 
  header("Content-Type:text/html");

  switch($page) {
    case 'map':
      $PageController->mapHomePage();
    break;
    case 'battle':
      $PageController->battlePage($battleId);
    break;
    default:
      $PageController->pageNotFound();
    die();
  }
}
