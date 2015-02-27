<?php
//This page is used when user clicks login with twitter to comment. They are then redirected to the Twitter Authorisation URL
// Based on https://twitteroauth.com/ to set up Twitter authentication
include('views/templates/head.php');
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

//New TwitterOAuth instance
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

//Generating a request token to authorise access user's account through OAuth, will only be good for a few minutes
$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

//Setting request token information in Session
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

//Authorise URL, users will go here to authorise the app and login
$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

//Automatically redirects the user to the twitter authorsation page
header("Location: " . $url);

?>
