<?php
// Followed tutorial on https://twitteroauth.com/ to set up Twitter authentication
include('views/templates/head.php');
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;



$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

header("Location: " . $url);

?>
