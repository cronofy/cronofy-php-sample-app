<?php

include("../config.php");

if($_POST['calendar']['name'] == ""){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/calendars/new.php?profileId=' . $_POST['calendar']['profile_id'] . '&errors[]=' . urlencode('Calendar name cannot be blank'));
}

$result = CronofyRequest(function(){
  return $GLOBALS['cronofy']->create_calendar(Array("profile_id" => $_POST['calendar']['profile_id'], "name" => $_POST['calendar']['name']));
});

if($result["error"]){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/calendars/new.php?profileId=' . $_POST['calendar']['profile_id'] . '&' . ErrorToQueryStringParams($result["error"]));

  exit;
}

DebugLog("Create calendar success - profile_id=`" . $_POST['calendar']['profile_id'] . "` - name=`" . $_POST['calendar']['name'] . "`");

header('Location: ' . $GLOBALS['DOMAIN'] . '/profiles/');
exit;

?>
