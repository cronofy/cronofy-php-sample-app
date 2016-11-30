<?php

include("../config.php");

if($_POST['calendar']['name'] == ""){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/calendars/new.php?profileId=' . $_POST['calendar']['profile_id'] . '&errors[]=' . urlencode('Calendar name cannot be blank'));
}

$cronofy->create_calendar(Array("profile_id" => $_POST['calendar']['profile_id'], "name" => $_POST['calendar']['name']));

DebugLog("Create calendar success - profile_id=`" . $_POST['calendar']['profile_id'] . "` - name=`" . $_POST['calendar']['name'] . "`");

header('Location: ' . $GLOBALS['DOMAIN'] . '/profiles/');
exit;

?>
