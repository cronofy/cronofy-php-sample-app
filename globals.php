<?php

include("lib/cronofy.php");

session_start();

$GLOBALS['CRONOFY_CLIENT_ID'] = "yptzUGc5Yq_oEWr-li2VZVjg9QE8EE2e";
$GLOBALS['CRONOFY_CLIENT_SECRET'] = "0YqKTZjhnezSkRqL37J-n6JElt-TEPYdsM7u5MFlLaYJqqCbsOOOM1IczNu5DtnEbkRiOEAu20TtZWEKL8OHbA";

$GLOBALS['DOMAIN'] = "http://localhost:8888";

$accessToken = '';
$refreshToken = '';
if(isset($_SESSION['refresh_token'])){
  $accessToken = $_SESSION['access_token'];
  $refreshToken = $_SESSION['refresh_token'];
} else {
  if(!isset($GLOBALS['SKIP_AUTH'])){
    header('Location: ' . $GLOBALS['DOMAIN']);
  }
}

$cronofy = new Cronofy($GLOBALS['CRONOFY_CLIENT_ID'], $GLOBALS['CRONOFY_CLIENT_SECRET'], $accessToken, $refreshToken);

set_exception_handler(function($e){
  if(is_a($e, "CronofyException") && $e->getMessage() == "Unauthorized"){
    if($GLOBALS['cronofy']->refresh_token()){
      $_SESSION['access_token'] = $GLOBALS['cronofy']->access_token;
      $_SESSION['refresh_token'] = $GLOBALS['cronofy']->refresh_token;

      header('Refresh:0');
      die;
    } else {
      unset($_SESSION['access_token']);
      unset($_SESSION['refresh_token']);

      header('Location: ' . $GLOBALS['DOMAIN']);
      die;
    }
  } else {
    throw $e;
  }
});
