<?php

include("lib/cronofy.php");

session_start();

$globals['CRONOFY_CLIENT_ID'] = "yptzUGc5Yq_oEWr-li2VZVjg9QE8EE2e";
$globals['CRONOFY_CLIENT_SECRET'] = "0YqKTZjhnezSkRqL37J-n6JElt-TEPYdsM7u5MFlLaYJqqCbsOOOM1IczNu5DtnEbkRiOEAu20TtZWEKL8OHbA";

$globals['DOMAIN'] = "http://localhost:8888";

$accessToken = '';
if(isset($_SESSION['access_token'])){
  $accessToken = $_SESSION['access_token'];
}

$refreshToken = '';
if(isset($_SESSION['refresh_token'])){
  $refreshToken = $_SESSION['refresh_token'];
}

$cronofy = new Cronofy($globals['CRONOFY_CLIENT_ID'], $globals['CRONOFY_CLIENT_SECRET'], $accessToken, $refreshToken);
