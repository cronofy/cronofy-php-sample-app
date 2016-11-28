<?php

include("../globals.php");

$cronofy->close_channel(Array("channel_id" => $_GET['channelId']));

$fileName = __DIR__ . "/calls/" . $_GET['channelId'];
if(file_exists($fileName)){
  unlink($fileName);
}

header('Location: ' . $GLOBALS['DOMAIN'] . '/channels/');
exit;

?>
