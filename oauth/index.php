<?php

require '../globals.php';

$redirect_uri = $globals['DOMAIN'] . '/oauth/';

if (!isset($_GET['code'])) {
  $authorizationUrl = $cronofy->getAuthorizationUrl(array(
    "redirect_uri" => $redirect_uri,
    "scope" => array("read_account","create_calendar","list_calendars","read_events","create_event","delete_event","read_free_busy","change_participation_status"),
  ));

  header('Location: ' . $authorizationUrl);
  exit;
} else {
  try {
    $cronofy->request_token(array("code" => $_GET['code'], "redirect_uri" => $redirect_uri));

    $_SESSION['access_token'] = $cronofy->access_token;
    $_SESSION['refresh_token'] = $cronofy->refresh_token;

    header('Location: ' . $globals['DOMAIN']);
  } finally {
    header('Location: ' . $globals['DOMAIN']);
  }
}
