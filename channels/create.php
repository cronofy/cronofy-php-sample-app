<?php

include("../config.php");

$callbackUrl = $GLOBALS['DOMAIN'] . '/push/?path=' . $_POST['channel']['path'];

$result = CronofyRequest(function(){
  $GLOBALS['cronofy']->create_channel(Array(
    "callback_url" => $GLOBALS['callbackUrl'],
    "filters" => Array(
      "only_managed" => $_POST['channel']['only_managed'],
      "calendar_ids" => $_POST['channel']['calendar_ids']
    )));
  });

if($result["error"]){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/channels/new.php?' . ErrorToQueryStringParams($result["error"]));

  exit;
}

DebugLog("Create channel success - callback_url=`" . $callbackUrl . "` - only_managed=`" . $_POST['channel']['only_managed'] . "` - calendar_ids=`" . join(',', $_POST['channel']['calendar_ids']) . "`");

header('Location: ' . $GLOBALS['DOMAIN'] . '/channels/');
exit;

?>
