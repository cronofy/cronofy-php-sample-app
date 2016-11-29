<?php
include("../config.php");

if(!isset($_GET['channelId'])){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/channels/');
  die;
}

$channels = $cronofy->list_channels()["channels"];

for($i = 0; $i < count($channels); $i++){
  if($channels[$i]["channel_id"] == $_GET['channelId']){
    $channel = $channels[$i];
  }
}

if(!isset($channel)){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/channels/');
  die;
}

$fileName = __DIR__ . "/calls/" . $channel["channel_id"] . ".json";
if(file_exists($fileName)){
  $file = fopen($fileName, "r");
  $channelDetails = json_decode(fread($file, filesize($fileName)), true);
  fclose($file);
}

include("../header.php"); ?>

<div class="row">
  <div class="col-xs-offset-8 col-xs-4 text-right">
    <a href="/channels/delete.php?channelId=<?= $channel["channel_id"] ?>" class="btn btn-danger">
      Close
    </a>
  </div>
</div>

<dl class="dl-horizontal">
  <dt>Channel ID</dt>
  <dd><?= $channel["channel_id"] ?></dd>

  <dt>Callback URL</dt>
  <dd><?= $channel["callback_url"] ?></dd>

  <dt>Only Managed</dt>
  <dd><?= isset($channel["filters"]["only_managed"]) && $channel["filters"]["only_managed"] ? "True" : "False" ?></dd>

  <? if(isset($channel["filters"]["calendar_ids"])){ ?>
    <dt>Calendar IDs</dt>
    <dd><pre><?= implode("\n", $channel["filters"]["calendar_ids"]) ?></pre></dd>
  <? } ?>

  <? if(isset($channelDetails)){ ?>
    <dt>Last Called</dt>
    <dd><?= $channelDetails["last_called"] ?></dd>

    <dt>Received Data</dt>
    <dd><pre><?= implode('<br />', $channelDetails["calls"]) ?></pre></dd>
  <? } ?>
</dl>

<?php include("../footer.php"); ?>
