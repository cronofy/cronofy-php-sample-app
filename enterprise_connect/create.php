<?php
include("./config.php");

$errors = [];

if($_POST['user']['email'] == ""){
  array_push($errors, "errors[]=" . urlencode("Email cannot be blank"));
}
if($_POST['user']['scope'] == ""){
  array_push($errors, "errors[]=" . urlencode("Scope cannot be blank"));
}

if(count($errors) > 0){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/enterprise_connect/new.php?' . join('&', $errors));
}

$cronofy->authorize_with_service_account(Array(
  "email" => $_POST['user']['email'],
  "scope" => $_POST['user']['scope'],
  "callback_url" => $GLOBALS['DOMAIN'] . "/enterprise_connect/push/?email=" . $_POST['user']['email']
));

DebugLog("Authorize with service account success - email=`" . $_POST['user']['email'] . "` - scope=`" . $_POST['user']['scope'] . "` - callback_url=`" . $GLOBALS['DOMAIN'] . "/enterprise_connect/push/?email=" . $_POST['user']['email'] . "`");

$dirName = __DIR__ . "/users";
$fileName = $dirName . "/" . $_POST['user']['email'] . ".json";

if(!file_exists($dirName)){
  mkdir($dirName);
}

if(!file_exists($fileName)){
  $file = fopen($fileName, "w");
  fwrite($file, json_encode(Array("email" => $_POST['user']['email'], "status" => "Pending")));
  fclose($file);

  DebugLog("Created service account user details file - fileName=`" . $fileName . "`");
} else {
  DebugLog("Service account user details file already exists so refrained from creating - fileName=`" . $fileName . "`");
}

header('Location: ' . $GLOBALS['DOMAIN'] . '/enterprise_connect/');
