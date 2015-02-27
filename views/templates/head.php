<?php
ob_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

session_start();

define('CONSUMER_KEY', 'YQaiUzS8v8HNvIJOg6KSRjMvW');
define('CONSUMER_SECRET', 'i9IFDhJitWKMnqapppJsDGFVCDjT1Zo6B9UpYlPsPFP1XHt629');
define('OAUTH_CALLBACK', 'http://civilwar.dev:8888/callback.php');
?>
<html lang="en">
  <head>
    <title>Civil War Map</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/css/style.css">
  </head>
  <body>
    <div class='wrapper'>
    <nav class='navbar navbar-default'>
      <ul class='nav navbar-nav'>
        <?php foreach($battles as $battle): ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              <?php echo $battle['name']; ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <a <?php echo 'href="?page=battle&id=' . $battle['id'] . '" alt="' . $battle['name'] . '"';?>>
                  <?php echo $battle['name']; ?> webpage
                </a>
              </li>
              <li>
                <a <?php echo 'href="?rss=battle&id=' . $battle['id'] . '" alt="' . $battle['name'] . '"';?>>
                  <?php echo $battle['name']; ?> RSS feed
                </a>
              </li>
            </ul>
          </li>

        <?php endforeach; ?>
      </ul>
    </nav>
