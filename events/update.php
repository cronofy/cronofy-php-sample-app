<?php

include("../config.php");

$errors = [];

$locationSet = false;

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
if($_POST['event']['location']['lat'] != "" || $_POST['event']['location']['long'] != ""){
  $locationSet = true;

  if($_POST['event']['location']['lat'] == ""){
    array_push($errors, "errors[]=" . urlencode("Latitude must be set if longitude is set"));
  } else if (!is_numeric($_POST['event']['location']['lat'])){
    array_push($errors, "errors[]=" . urlencode("Latitude must be a float"));
  } else if ((float)$_POST['event']['location']['lat'] < -85.05115 || (float)$_POST['event']['location']['lat'] > 85.05115) {
    array_push($errors, "errors[]=" . urlencode("Latitude must be between -85.05115 and 85.05115"));
  }
  if($_POST['event']['location']['long'] == ""){
    array_push($errors, "errors[]=" . urlencode("Longitude must be set if latitude is set"));
  } else if (!is_numeric($_POST['event']['location']['long'])){
    array_push($errors, "errors[]=" . urlencode("Longitude must be a float"));
  } else if ((float)$_POST['event']['location']['long'] < -180 || (float)$_POST['event']['location']['long'] > 180) {
    array_push($errors, "errors[]=" . urlencode("Longitude must be between -180 and 180"));
  }
}

if(count($errors) > 0){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/events/edit.php?eventUid=' . $_POST['event']['event_uid'] . '&calendarId=' . $_POST['event']['calendar_id'] . '&' . join('&', $errors));
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

if($locationSet){
  $event["location"] = array(
    "lat" => $_POST['event']['location']['lat'],
    "long" => $_POST['event']['location']['long']
  );
}

$cronofy->upsert_event($event);

$successLog = "Update event success - event_id=`" . $_POST['event']['event_id'] . "` - calendar_id=`" . $_POST['event']['calendar_id'] . "` - summary=`" . $_POST['event']['summary'] . "` - description=`" . $_POST['event']['description'] . "` - start=`" . $_POST['event']['start'] . "` - end=`" . $_POST['event']['end'] . "`";

if($locationSet){
  $successLog .= " - location.lat=`" . $_POST['event']['location']['lat'] . "` - location.long=`" . $_POST['event']['location']['long'] . "`";
}

DebugLog($successLog);

header('Location: ' . $GLOBALS['DOMAIN'] . '/events/show.php?calendarId=' . $_POST['event']['calendar_id'] . '&eventUid=' . $_POST['event']['event_uid']);
exit;

?>
