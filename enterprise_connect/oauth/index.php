<?php
$GLOBALS['SKIP_AUTH'] = true;

require '../../config.php';

$redirect_uri = $GLOBALS['DOMAIN'] . '/enterprise_connect/oauth/';

if (!isset($_GET['code'])) {
  $authorizationUrl = $cronofy->getEnterpriseConnectAuthorizationUrl(array(
    "redirect_uri" => $redirect_uri,
    "delegated_scope" => array("read_account","create_calendar","list_calendars","read_events","create_event","delete_event","read_free_busy","change_participation_status"),
    "scope" => array("service_account/accounts/manage","service_account/resources/manage","service_account/accounts/unrestricted_access","service_account/resources/unrestricted_access"),
  ));

  DebugLog("Redirect user to Service Accounts OAuth");

  header('Location: ' . $authorizationUrl);
  exit;
} else {
  try {
    $cronofy->request_token(array("code" => $_GET['code'], "redirect_uri" => $redirect_uri));

    $_SESSION['service_account_access_token'] = $cronofy->access_token;
    $_SESSION['service_account_refresh_token'] = $cronofy->refresh_token;

    DebugLog("Service Account OAuth successful");

    $fileName = __DIR__ . "/../push/credentials.json";

    $file = fopen($fileName, "w");
    fwrite($file, json_encode(Array("access_token" => $cronofy->access_token, "refresh_token" => $cronofy->refresh_token)));
    fclose($file);

    DebugLog("Service Account credentials stored - fileName=`" . $fileName . "`");

    header('Location: ' . $GLOBALS['DOMAIN'] . '/enterprise_connect/');
  } catch(CronofyException $ex) {
    DebugLog("Service Account OAuth unsuccessful - " . print_r($ex->error_details(), true));
  } finally {
    header('Location: ' . $GLOBALS['DOMAIN'] . '/enterprise_connect/');
  }
}
