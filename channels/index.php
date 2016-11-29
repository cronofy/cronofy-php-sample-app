<?php
include("../config.php");

$channels = $cronofy->list_channels()["channels"];

include("../header.php"); ?>

<div class="row">
  <div class="col-xs-8">
    <h2>Channels</h2>
  </div>
  <div class="col-xs-4 text-right">
    <a href="/channels/new.php" class="btn btn-primary">
      Create Channel
    </a>
  </div>
</div>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Channel ID</th>
      <th>Path</th>
      <th></th>
    </tr>
  </thead>

  <tbody>
    <? for($i = 0; $i < count($channels); $i++){ ?>
      <tr>
        <td>
          <?= $channels[$i]["channel_id"] ?>
        </td>
        <td>
          <?= $channels[$i]["callback_url"] ?>
        </td>
        <td>
          <a href="/channels/show.php?channelId=<?= $channels[$i]["channel_id"] ?>">
            View
          </a>
        </td>
      </tr>
      <? } ?>
    </tbody>
  </table>

<?php include("../footer.php"); ?>
