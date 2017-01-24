<?php
$GLOBALS['SKIP_AUTH'] = true;

include("../config.php");

$authUrl = $cronofy->getAuthorizationURL(array(
  "redirect_uri" => $GLOBALS['DOMAIN'] . "/availability/account_id.php",
  "scope" => array("read_account", "read_events", "read_free_busy"),
));

try {
$cronofy->request_token(array("code" => $_GET['code'], "redirect_uri" => $GLOBALS['DOMAIN'] . "/availability/account_id.php"));
} catch(Exception $ex){
  header('Location: ' . $authUrl);
}

include("../header.php"); ?>

<p>Your account ID is:</p>
<pre><code><?= $cronofy->get_account()["account"]["account_id"] ?></code></pre>
<p>In order to get another user's account ID, ask them to visit this URL, follow the authentication flow and let you know what account ID is displayed:</p><a href="<?= $authUrl ?>"><?= $authUrl ?></a>
