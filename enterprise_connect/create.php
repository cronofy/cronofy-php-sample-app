<?php
include("./config.php");

$cronofy->authorize_with_service_account(Array(
  "email" => $_POST['user']['email'],
  "scope" => $_POST['user']['scope'],
  "callback_url" => $GLOBALS['DOMAIN'] . "/enterprise_connect/push/?email=" . $_POST['user']['email']
));

$dirName = __DIR__ . "/users";
$fileName = $dirName . "/" . $_POST['user']['email'] . ".json";

if(!file_exists($dirName)){
  mkdir($dirName);
}

if(!file_exists($fileName)){
  $file = fopen($fileName, "w");
  fwrite($file, json_encode(Array("email" => $_POST['user']['email'], "status" => "Pending")));
  fclose($file);
}

header('Location: ' . $GLOBALS['DOMAIN'] . '/enterprise_connect/');
