<?php

include("lib/cronofy.php");

function DebugLog($log){
  $result = file_put_contents(__DIR__ . "/log/debug.log", date("c") . " - " . $log . "\n", FILE_APPEND);
}

$GLOBALS['CRONOFY_CLIENT_ID'] = "yptzUGc5Yq_oEWr-li2VZVjg9QE8EE2e";
$GLOBALS['CRONOFY_CLIENT_SECRET'] = "0YqKTZjhnezSkRqL37J-n6JElt-TEPYdsM7u5MFlLaYJqqCbsOOOM1IczNu5DtnEbkRiOEAu20TtZWEKL8OHbA";

$GLOBALS['DOMAIN'] = "http://5e8fb4a9.ngrok.io";
