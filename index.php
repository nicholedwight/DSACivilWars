<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


require './database/Database.php';
require './models/battles-model.php';
require './models/comments-model.php';
require './controllers/PageController.php';
require './controllers/ResourceController.php';
$Db = Database::getInstance();
$battles = new Battles($Db);
$comments = new Comments($Db);

define("FILELOCATION", dirname(__FILE__));

$models = array('battles' => $battles, 'comments' => $comments);

$PageController = new Controller\Page($models);
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

if(isset($_GET['name'])) {
  $battleName = str_replace('_', ' ', $_GET['name']);
}
else {
  $battleName = 'Battle of Adwalton Moor';
}

// If JSON is requested send data as JSON.
// The route is used in global.js file to supply data as JSON for the map.
if(isset($_GET['json'])) {
  $resource = $_GET['json'];


  header_remove();
  header("Content-Type:application/json");
  switch($resource) {
    case 'battles':
      $ResourceController->battlesDataAsJSON();
    break;
    case 'battle_by_name':
      $ResourceController->sendBattleByNameAsJSON($battleName);
    break;
    case 'people_by_battle_id':
      $ResourceController->sendFactionsByBattleIdAsJSON($battleId);
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
