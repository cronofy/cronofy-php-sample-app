<?php
include("../config.php");

$availablePeriods = [];

$errors = [];

if(ISSET($_POST['availabilityInfo'])){
  if($_POST['availabilityInfo']['accountId'][0] == ""){
    array_push($errors, "Account ID 1 cannot be blank");
  }
  if($_POST['availabilityInfo']['accountId'][0] == $_POST['availabilityInfo']['accountId'][1]){
    array_push($errors, "Account IDs must be different");
  }
  if($_POST['availabilityInfo']['requiredParticipants'] == ""){
    array_push($errors, "Required participants cannot be blank");
  }
  if(!($_POST['availabilityInfo']['requiredParticipants'] == "all" || $_POST['availabilityInfo']['requiredParticipants'] == "1")){
    array_push($errors, "Required participants must be \"all\" or 1");
  }
  if($_POST['availabilityInfo']['duration'] == ""){
    array_push($errors, "Duration cannot be blank");
  }
  if($_POST['availabilityInfo']['start'] == ""){
    array_push($errors, "Start time cannot be blank");
  }
  if(time() > strtotime($_POST['availabilityInfo']['start'])){
    array_push($errors, "Start time must be in the future");
  }
  if((new DateTime(date('Y-m-d')))->diff(new DateTime($_POST['availabilityInfo']['start']))->format('%a') > 35){
    array_push($errors, "Start time must be within 35 days of today");
  }
  if($_POST['availabilityInfo']['end'] == ""){
    array_push($errors, "End time cannot be blank");
  }
  if($_POST['availabilityInfo']['start'] > $_POST['availabilityInfo']['end']){
    array_push($errors, "Start time cannot be after end time");
  }
  if(round(abs(strtotime($_POST['availabilityInfo']['end']) - strtotime($_POST['availabilityInfo']['start'])) / 60,2) > (24 * 60) + 1){
    array_push($errors, "End time must be within 24 hours and 1 minute of start time");
  }

  if(count($errors) == 0){
    $params = array("participants" => array(array("members" => array(
      array("sub" => $_POST['availabilityInfo']['accountId'][0]),
    ), "required" => $_POST['availabilityInfo']['requiredParticipants'])),
    "required_duration" => array("minutes" => $_POST['availabilityInfo']['duration']),
    "available_periods" => array(
      array(
        "start" => date('c', strtotime($_POST['availabilityInfo']['start'])),
        "end" => date('c', strtotime($_POST['availabilityInfo']['end']))
      )));

    if($_POST['availabilityInfo']['accountId'][1]){
      array_push($params["participants"]["members"], array("sub" => $_POST['availabilityInfo']['accountId'][1]));
    }

    $availabilityInfo = $cronofy->availability($params);

    $availablePeriods = $availabilityInfo["available_periods"];
  }
}

$authUrl = $cronofy->getAuthorizationURL(array(
  "redirect_uri" => $GLOBALS['DOMAIN'] . "/availability/account_id.php",
  "scope" => array("read_account", "read_events", "read_free_busy"),
));

$startDate = (new DateTime())->modify('+1 day');
$endDate = (new DateTime())->modify('+2 day');

include("../header.php"); ?>

<h2>Availability</h2>

<div class="well">
  <? if(count($errors) > 0){ ?>
    <div id="error_explanation" class="alert alert-danger">
      <ul>
        <? for($i = 0; $i < count($errors); $i++){ ?>
          <li><?= $errors[$i] ?></li>
        <? } ?>
      </ul>
    </div>
  <? } ?>

  <form class="form-horizontal" action="/availability/index.php" method="post">
    <fieldset>
      <div class="form-group">
        <label class="control-label col-lg-2">Account ID 1</label>
        <div class="col-lg-10">
          <input class="form-control" type="text" name="availabilityInfo[accountId][0]" value="<?= $_POST['availabilityInfo']['accountId'][0] ?? $cronofy->get_account()["account"]["account_id"] ?>" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Account ID 2</label>
        <div class="col-lg-10">
          <input class="form-control" type="text" name="availabilityInfo[accountId][1]" value="<?= $_POST['availabilityInfo']['accountId'][1] ?? "" ?>" />
          <span class="help-block">Send someone <a href="<?= $authUrl ?>" target="_blank">this</a> to find their Account ID</span>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Required Participants</label>
        <div class="col-lg-10">
          <select name="availabilityInfo[requiredParticipants]" class="form-control">
            <option <? if(($_POST['availabilityInfo']['requiredParticipants']??"") == "1"){?>selected<?}?>>1</option>
            <option value="all" <? if(($_POST['availabilityInfo']['requiredParticipants']??"") == "all"){?>selected<?}?>>All</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Duration (Minutes)</label>
        <div class="col-lg-10">
          <input type="number" class="form-control" name="availabilityInfo[duration]" value="<?= $_POST['availabilityInfo']['duration'] ?? "60" ?>" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Start Time</label>
        <div class="col-lg-10">
          <input class="form-control" type="datetime-local" name="availabilityInfo[start]" value="<?= $_POST['availabilityInfo']['start'] ?? $startDate->format('Y-m-d\T00:00') ?>" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">End Time</label>
        <div class="col-lg-10">
          <input class="form-control" type="datetime-local" name="availabilityInfo[end]" value="<?= $_POST['availabilityInfo']['end'] ?? $endDate->format('Y-m-d\T00:00') ?>" />
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-10">
          <input type="submit" value="Find Availability" class="btn btn-success btn-primary" />
        </div>
      </div>
    </fieldset>
  </form>
</div>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Start Time</th>
      <th>End Time</th>
      <th>Participants</th>
    </tr>
  </thead>

  <tbody>
    <? for($i = 0; $i < count($availablePeriods); $i++){ ?>
      <tr>
        <td>
          <?= $availablePeriods[$i]["start"] ?>
        </td>
        <td>
          <?= $availablePeriods[$i]["end"] ?>
        </td>
        <td>
          <? for($j = 0; $j < count($availablePeriods[$i]["participants"]); $j++){ ?>
            <?= $availablePeriods[$i]["participants"][$j]["sub"] ?><br />
          <? } ?>
        </td>
      </tr>
      <? } ?>
    </tbody>
  </table>
