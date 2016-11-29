<?php
include("../globals.php");

if(!isset($_GET['email'])){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/enterprise_connect/');
}

$fileName = __DIR__ . "/../enterprise_connect/users/" . $_GET['email'] . ".json";
$userCredentialsFile = fopen($fileName, "r");
$userCredentials = json_decode(fread($userCredentialsFile, filesize($fileName)), true);

$cronofy = new Cronofy($GLOBALS['CRONOFY_CLIENT_ID'], $GLOBALS['CRONOFY_CLIENT_SECRET'], $userCredentials["access_token"], $userCredentials["refresh_token"]);
