<?php

include("../config.php");

$errors = [];

if($_POST['event']['event_id'] == ""){
  array_push($errors, "errors[]=" . urlencode("Event ID cannot be blank"));
}
if($_POST['event']['summary'] == ""){
  array_push($errors, "errors[]=" . urlencode("Summary cannot be blank"));
}
if($_POST['event']['start'] == ""){
  array_push($errors, "errors[]=" . urlencode("Start time cannot be blank"));
}
if($_POST['event']['end'] == ""){
  array_push($errors, "errors[]=" . urlencode("End time cannot be blank"));
}
if($_POST['event']['start'] > $_POST['event']['end']){
  array_push($errors, "errors[]=" . urlencode("Start time cannot be after end time"));
}

if(count($errors) > 0){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/events/new.php?calendarId=' . $_POST['event']['calendar_id'] . '&' . join('&', $errors));
}

$event = Array(
  "tzid" => "Etc/UTC",
  "event_id" => $_POST['event']['event_id'],
  "calendar_id" => $_POST['event']['calendar_id'],
  "summary" => $_POST['event']['summary'],
  "description" => $_POST['event']['description'],
  "start" => date('c', strtotime($_POST['event']['start'])),
  "end" => date('c', strtotime($_POST['event']['end'])),
);

$result = CronofyRequest(function(){
  return $GLOBALS['cronofy']->upsert_event($GLOBALS['event']);
});

if($result["error"]){
  header('Location: ' . $GLOBALS['DOMAIN'] . 'service_account_users/events/new.php?calendarId=' . $_POST['event']['calendar_id'] . '&' . ErrorToQueryStringParams($result["error"]));

  exit;
}

DebugLog("Service account create event success - event_id=`" . $_POST['event']['event_id'] . "` - calendar_id=`" . $_POST['event']['calendar_id'] . "` - summary=`" . $_POST['event']['summary'] . "` - description=`" . $_POST['event']['description'] . "` - start=`" . $_POST['event']['start'] . "` - end=`" . $_POST['event']['end'] . "`");

header('Location: ' . $GLOBALS['DOMAIN'] . '/service_account_users/calendars/show.php?email=' . $_POST['email'] . '&calendarId=' . $_POST['event']['calendar_id']);
exit;

?>
