<?php
include("../globals.php");

$freeBusyInfo = $cronofy->free_busy(Array("tzid" => "Etc/UTC"));
$calendarList = $cronofy->list_calendars()["calendars"];

$calendars = array();

foreach($freeBusyInfo->each() as $freeBusy){
  $calendarId = $freeBusy["calendar_id"];

  if(!isset($calendars[$calendarId])){
    $calendarName = "";

    for($i = 0; $i < count($calendarList); $i++){
      if($calendarList[$i]["calendar_id"] == $calendarId){
        $calendarName = $calendarList[$i]["calendar_name"];
      }
    }

    $calendars[$calendarId] = array(
      "calendar_name" => $calendarName,
      "free_busy" => array()
    );
  }

  array_push($calendars[$calendarId]["free_busy"], $freeBusy);
}

include("../header.php"); ?>

<h2>Free Busy</h2>

<? foreach($calendars as $calendarId => $calendar){ ?>
  <h3><?= $calendar["calendar_name"] ?></h3>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Status</th>
        <th>Start Time</th>
        <th>End Time</th>
      </tr>
    </thead>

    <tbody>
      <? for($j = 0; $j < count($calendar["free_busy"]); $j++){ ?>
        <tr>
          <td>
            <?= $calendar["free_busy"][$j]["free_busy_status"] ?>
          </td>
          <td>
            <?= $calendar["free_busy"][$j]["start"] ?>
          </td>
          <td>
            <?= $calendar["free_busy"][$j]["end"] ?>
          </td>
        </tr>
      <? } ?>
    </tbody>
  </table>
<? } ?>

<?php include("../footer.php"); ?>
