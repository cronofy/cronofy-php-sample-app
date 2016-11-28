<?php

include("../globals.php");

$cronofy->create_channel(Array(
  "callback_url" => $GLOBALS['DOMAIN'] . '/push/?path=' . $_POST['channel']['path'],
  "filters" => Array(
    "only_managed" => $_POST['channel']['only_managed'],
    "calendar_ids" => $_POST['channel']['calendar_ids']
  )));

header('Location: ' . $GLOBALS['DOMAIN'] . '/channels');
exit;

?>
