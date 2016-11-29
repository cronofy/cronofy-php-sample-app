<?php
include("../config.php");

$calendars = $cronofy->list_calendars()["calendars"];

$profiles = array();

for($i = 0; $i < count($calendars); $i++){
  $profileId = $calendars[$i]["profile_id"];

  if(!isset($profiles[$profileId])){
    $profiles[$profileId] = array(
      "profile_name" => $calendars[$i]["profile_name"],
      "calendars" => array()
    );
  }

  array_push($profiles[$profileId]["calendars"], $calendars[$i]);
}

include("../header.php"); ?>

<h2>Calendars</h2>

<? foreach($profiles as $profileId => $profile){ ?>
  <div class="row">
    <div class="col-xs-8">
      <h3><?= $profile["profile_name"] ?></h3>
    </div>

    <div class="col-xs-4 text-right">
      <a href="/calendars/new.php?profileId=<?= $profileId ?>" class="btn btn-primary">
        New Calendar
      </a>
    </div>
  </div>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <? for($j = 0; $j < count($profile["calendars"]); $j++){ ?>
        <tr>
          <td>
            <?= $profile["calendars"][$j]["calendar_name"] ?>
          </td>
          <td>
            <a href="/calendars/show.php?calendarId=<?= $profile["calendars"][$j]["calendar_id"] ?>">
              View
            </a>
          </td>
        </tr>
      <? } ?>
    </tbody>
  </table>
<? } ?>


<?php include("../footer.php"); ?>
