<?php
ob_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

//Starting session for Twitter Comments
session_start();

//Constructing a TwitterOAuth instance and defining the callback URL for returning from Twitter authorisation
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
    <header class="default" role="banner">
      <nav class='navbar'>
        <div class="navbar-collapse">
          <ul class='navbar-nav'>
            <?php foreach($battles as $battle): ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  <?php echo $battle['name']; ?>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li>
                    <a <?php echo "href='battle" . $battle['id'] . "'";?>>
                      <?php echo $battle['name']; ?> webpage
                    </a>
                  </li>
                  <li>
                    <a <?php echo 'href="./rss/battle'. $battle['id'] . '"';?>>
                      <?php echo $battle['name']; ?> RSS feed
                    </a>
                  </li><li>
                    <a <?php echo 'href="./'. str_replace(' ', '_', $battle['name']) . '"';?>>
                      Battle data as JSON REST Service
                    </a>
                  </li>
                  <li>
                    <a <?php echo 'href="./battle'. $battle['id'] . '/people" alt="' . $battle['name'] . '"';?>>
                      Factions and People data as JSON REST Service
                    </a>
                  </li>
                </ul>
            </li>
            <?php endforeach; ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                Individual Components
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="/individual/nichole.html">Ashley Nichole Dwight</a></li>
                <li><a href="/individual/zia.html">Zia Grosvenor</a></li>
                <li><a href="/individual/julian.html">Julian</a></li>
                <li><a href="/individual/dom.html">Dom Aarvold</a></li>
              </ul>
            </li>
          </ul>

        </div>
      </nav>
    </header>
