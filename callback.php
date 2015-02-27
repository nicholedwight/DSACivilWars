<?php
//This page is used when returning from the Twitter Authorisation URL
include('views/templates/head.php');
require './database/Database.php';
require './models/comments-model.php';
//Import the TwitterOAuth class
require "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

//Pulling the temporary oauth_token back out of sessions. If the oauth_token is different from the one you sent user to Twitter with, abort the flow and don't continue with authorization.
$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
  //Abort! Something is wrong.
}

//Make TwitterOAuth instance with the temporary request token
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

//Getting access_token that authorized from temporary request token to act as the user
$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));

//Saving the credentials to Session
$_SESSION['access_token'] = $access_token;

//Pulling credentials out of Session storage
$access_token = $_SESSION['access_token'];

//Making a TwitterOAuth instance with the users access_token
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

//Access_token that is authorized acts as the user
$user = $connection->get("account/verify_credentials");
//Defining variables for functions
$_SESSION['profile_image_url'] = $user->profile_image_url;
$userid = $_SESSION['access_token']['user_id'];
$username = $_SESSION['access_token']['screen_name'];
$profile_image_url = $_SESSION['profile_image_url'];

//Instantiating the Comments Model in order to call the functions to check if a user is already registered in our DB or not
$Db = Database::getInstance();
$comments = new Comments($Db);

//Calling those functions to check the DB for user, if not then it registers them
if (!$comments->getUserInfoByID($userid)) {
  $comments->registerNewUser($userid, $username, $profile_image_url);
}

//Checking for a redirectURL to take the user back to the battle info page they were previously on (cookie should have been set there)
if(!isset($_COOKIE['redirectURL'])) {
  // No cookies are set
} else {
  // Cookie has been set
  $redirect = "http://" . $_COOKIE['redirectURL'];
}

//Redirects the user back to previous battle info page
header("Location: " . $redirect);
?>
