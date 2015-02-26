<?php
include('views/templates/head.php');

//Using the cookie to redirect the user back to previous page before logout
if(!isset($_COOKIE['redirectURL'])) {
  // No cookies are set
} else {
  // Cookie has been set
  $redirect = "http://" . $_COOKIE['redirectURL'];
}
session_destroy();
header('Location: ' . $redirect);
