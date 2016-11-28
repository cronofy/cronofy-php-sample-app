<?php

include("lib/cronofy.php");

session_start();

$GLOBALS['CRONOFY_CLIENT_ID'] = "yptzUGc5Yq_oEWr-li2VZVjg9QE8EE2e";
$GLOBALS['CRONOFY_CLIENT_SECRET'] = "0YqKTZjhnezSkRqL37J-n6JElt-TEPYdsM7u5MFlLaYJqqCbsOOOM1IczNu5DtnEbkRiOEAu20TtZWEKL8OHbA";

$GLOBALS['DOMAIN'] = "http://0b6ed710.ngrok.io";

$accessToken = '';
$refreshToken = '';

$accessTokenKey = isset($GLOBALS['ACCESS_TOKEN_KEY']) ? $GLOBALS['ACCESS_TOKEN_KEY'] : "access_token";
$refreshTokenKey = isset($GLOBALS['REFRESH_TOKEN_KEY']) ? $GLOBALS['REFRESH_TOKEN_KEY'] : "refresh_token";
$loginPath = isset($GLOBALS['LOGIN_PATH']) ? $GLOBALS['LOGIN_PATH'] : "/";

if(isset($_SESSION[$refreshTokenKey])){
  $accessToken = $_SESSION[$accessTokenKey];
  $refreshToken = $_SESSION[$refreshTokenKey];
} else {
  if(!isset($GLOBALS['SKIP_AUTH'])){
    header('Location: ' . $GLOBALS['DOMAIN'] . $loginPath);
  }
}

$cronofy = new Cronofy($GLOBALS['CRONOFY_CLIENT_ID'], $GLOBALS['CRONOFY_CLIENT_SECRET'], $accessToken, $refreshToken);

set_exception_handler(function($e){
  if(is_a($e, "CronofyException") && $e->getMessage() == "Unauthorized"){
    if($GLOBALS['cronofy']->refresh_token()){
      $_SESSION[$GLOBALS['accessTokenKey']] = $GLOBALS['cronofy']->access_token;
      $_SESSION[$GLOBALS['refreshTokenKey']] = $GLOBALS['cronofy']->refresh_token;

      header('Refresh:0');
      die;
    } else {
      unset($_SESSION[$GLOBALS['accessTokenKey']]);
      unset($_SESSION[$GLOBALS['refreshTokenKey']]);

      header('Location: ' . $GLOBALS['DOMAIN'] . $loginPath);
      die;
    }
  } else {
    throw $e;
  }
});
