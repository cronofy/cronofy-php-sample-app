<?php

include("../config.php");

$errors = [];

$geoLocationSet = false;

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
if($_POST['event']['location']['lat'] != "" || $_POST['event']['location']['long'] != ""){
  $geoLocationSet = true;

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

if($_POST['event']['location']['description'] != ''){
  $event["location"] = array(
    "description" => $_POST['event']['location']['description']
  );
}

if($geoLocationSet){
  if(!isset($event["location"])){
    $event["location"] = array();
  }

  $event["location"]["lat"] = $_POST['event']['location']['lat'];
  $event["location"]["long"] = $_POST['event']['location']['long'];
}

$result = CronofyRequest(function(){
  return $GLOBALS['cronofy']->upsert_event($GLOBALS['event']);
});

if($result["error"]){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/events/new.php?calendarId=' . $_POST['event']['calendar_id'] . '&' . ErrorToQueryStringParams($result["error"]));

  exit;
}

$successLog = "Create event success - event_id=`" . $_POST['event']['event_id'] . "` - calendar_id=`" . $_POST['event']['calendar_id'] . "` - summary=`" . $_POST['event']['summary'] . "` - description=`" . $_POST['event']['description'] . "` - start=`" . $_POST['event']['start'] . "` - end=`" . $_POST['event']['end'] . "`";

if($geoLocationSet){
  $successLog .= " - location.lat=`" . $_POST['event']['location']['lat'] . "` - location.long=`" . $_POST['event']['location']['long'] . "`";
}

DebugLog($successLog);

header('Location: ' . $GLOBALS['DOMAIN'] . '/calendars/show.php?calendarId=' . $_POST['event']['calendar_id']);
exit;

?>
