<?php

include("globals.php");

session_start();

date_default_timezone_set("UTC");

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

$cronofy = new Cronofy(array(
  "client_id" => $GLOBALS['CRONOFY_CLIENT_ID'],
  "client_secret" => $GLOBALS['CRONOFY_CLIENT_SECRET'],
  "access_token" => $accessToken,
  "refresh_token" => $refreshToken
));

function CronofyRequest($call){
  $result = array(
    "data" => null,
    "error" => null
  );

  try{
    $result["data"] = $call();
  } catch(CronofyException $ex){
    if($ex->getCode() == 401){
      return RefreshToken($call);
    }

    DebugLog("CronofyException: message=`" . $ex->getMessage() . "` error_details=`" . print_r($ex->error_details(), true) . "`");
    $result["error"] = $ex;
  }

  return $result;
}

function RefreshToken($call){
  try {
    $GLOBALS['cronofy']->refresh_token();

    $result = array(
      "data" => null,
      "error" => null
    );

    DebugLog("Cronofy access token has been refreshed");

    $_SESSION[$GLOBALS['accessTokenKey']] = $GLOBALS['cronofy']->access_token;
    $_SESSION[$GLOBALS['refreshTokenKey']] = $GLOBALS['cronofy']->refresh_token;
  }
  catch(CronofyException $ex){
    DebugLog("Cronofy access has been revoked");

    unset($_SESSION[$GLOBALS['accessTokenKey']]);
    unset($_SESSION[$GLOBALS['refreshTokenKey']]);

    header('Location: ' . $GLOBALS['DOMAIN'] . $GLOBALS['loginPath']);
    die;
  }

  try{
    $result["data"] = $call();
  } catch(CronofyException $ex){
    DebugLog("CronofyException: message=`" . $e->getMessage() . "` error_details=`" . print_r($e->error_details(), true) . "`");
    $result["error"] = $ex;
  }

  return $result;
}

function ServerErrorBlockFromResult($result){
  if(!$result || !$result["error"]){
    return;
  }

  $errorCode = $result["error"]->getCode();
  $errorStatus = $result["error"]->getMessage();
  $serverError = $result["error"]->error_details();

  return ServerErrorBlock($errorCode, $errorStatus, $serverError);
}

function ServerErrorBlockFromGet(){
  if(!isset($_GET['errorCode'])){
    return;
  }

  $errorCode = $_GET['errorCode'];
  $errorStatus = $_GET['errorStatus'];
  $serverError = $_GET['serverError'];

  return ServerErrorBlock($errorCode, $errorStatus, $serverError);
}

function ServerErrorBlock($errorCode, $errorStatus, $serverError){
  return "
<div id='error_explanation' class='alert alert-danger'>
  <h4>$errorCode - $errorStatus</h4>
  <pre>" . print_r($serverError, true) ."</pre>
</div>
  ";
}
