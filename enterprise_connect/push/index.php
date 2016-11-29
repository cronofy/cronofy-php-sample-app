<?php

include("../../globals.php");

$credentialsFileName = __DIR__ . "/credentials.json";
if(!file_exists($credentialsFileName)){
  // log
  exit;
}

function UpdateUserFile($content){
  $file = fopen(__DIR__ . "/../users/" . $_GET['email'] . '.json', "w");
  fwrite($file, json_encode($content));
  fclose($file);
}

$body = file_get_contents('php://input');
$data = json_decode($body, true);

if(!isset($data["authorization"]["code"])){
  UpdateUserFile(Array(
    "email" => $_GET['email'],
    "status" => "Failed",
  ));

  exit;
}

$credentialsFile = fopen($credentialsFileName, "r");
$credentials = json_decode(fread($credentialsFile, filesize($credentialsFileName)), true);

$cronofy = new Cronofy($GLOBALS['CRONOFY_CLIENT_ID'], $GLOBALS['CRONOFY_CLIENT_SECRET'], $credentials["access_token"], $credentials["refresh_token"]);

$cronofy->request_token(array("code" => $data["authorization"]["code"], "redirect_uri" => $GLOBALS['DOMAIN'] . "/enterprise_connect/push/?email=" . $_GET['email']));

UpdateUserFile(Array(
  "email" => $_GET['email'],
  "status" => "Linked",
  "access_token" => $cronofy->access_token,
  "refresh_token" => $cronofy->refresh_token
));
