<?php

include("lib/cronofy.php");

function DebugLog($log){
  $result = file_put_contents(__DIR__ . "/log/debug.log", date("c") . " - " . $log . "\n", FILE_APPEND);
}

$GLOBALS['CRONOFY_CLIENT_ID'] = "kcmpdJJVDS8DtUwGOPlyGuSLQgLt4q6m";
$GLOBALS['CRONOFY_CLIENT_SECRET'] = "vQbzdUNrv3VPsP69TELuuhkrV29U27yL7wbo0PiOvlSDVCMA_3yVavyXuk0-nYnAtX7zsEmyqBnTbRDN94DLTQ";

$GLOBALS['DOMAIN'] = "http://php.ngrok.io";

if($GLOBALS['CRONOFY_CLIENT_ID'] == "" || $GLOBALS['CRONOFY_CLIENT_SECRET'] == "" || $GLOBALS['DOMAIN'] == ""){
  header('Location: /setup.php');
}
