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
