<?php

include("../globals.php");

$cronofy->create_calendar(Array("profile_id" => $_POST['calendar']['profile_id'], "name" => $_POST['calendar']['name']));

header('Location: ' . $GLOBALS['DOMAIN'] . '/profiles/');
exit;

?>
