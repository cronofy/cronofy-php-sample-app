<?php
include 'vendor/autoload.php';

function DebugLog($log){
  $result = file_put_contents(__DIR__ . "/log/debug.log", date("c") . " - " . $log . "\n", FILE_APPEND);
}

$GLOBALS['CRONOFY_CLIENT_ID'] = "";
$GLOBALS['CRONOFY_CLIENT_SECRET'] = "";

$GLOBALS['DOMAIN'] = "";

if($GLOBALS['CRONOFY_CLIENT_ID'] == "" || $GLOBALS['CRONOFY_CLIENT_SECRET'] == "" || $GLOBALS['DOMAIN'] == ""){
  header('Location: setup.php');
}
