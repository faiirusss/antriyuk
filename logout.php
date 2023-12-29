<?php
session_start();
require_once 'vendor/autoload.php';

include('config.php');
$accesstoken = $_SESSION['access_token'];
unset($_SESSION["auto"]);
unset($_SESSION['token']);

//Reset OAuth access token
$client = new Google_Client();
$client->revokeToken($accesstoken);

//Destroy entire session data.
session_destroy();

//redirect page to index.php
header('Location: login.php');
