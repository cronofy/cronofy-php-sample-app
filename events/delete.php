<?php

include("../config.php");

$cronofy->delete_event(Array("calendar_id" => $_POST['event']['calendar_id'], "event_id" => $_POST['event']['event_id']));

DebugLog("Delete event success - event_id=`" . $_POST['event']['event_id'] . "` - calendar_id=`" . $_POST['event']['calendar_id'] . "`");

header('Location: ' . $GLOBALS['DOMAIN'] . '/calendars/show.php?calendar_id=' . $_POST['event']['calendar_id']);
exit;

?>
