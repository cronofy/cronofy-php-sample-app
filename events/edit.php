<?php
include("../config.php");

function GoBack(){
  if(isset($_GET['calendarId'])){
    header('Location: ' . $GLOBALS['DOMAIN'] . '/calendars/show.php?calendarId=' . $_GET['calendarId']);
  } else {
    header('Location: ' . $GLOBALS['DOMAIN'] . '/profiles/');
  }
  die;
}

if(!isset($_GET['eventUid'])){
  GoBack();
}

$calendars = $cronofy->list_calendars()["calendars"];

for($i = 0; $i < count($calendars); $i++){
  if($calendars[$i]["calendar_id"] == $_GET['calendarId']){
    $calendar = $calendars[$i];
  }
}

if(!isset($calendar)){
  GoBack();
}

$events = $cronofy->read_events(array("tzid" => "Etc/UTC", "include_managed" => true, "calendar_ids" => array($calendar["calendar_id"])));

foreach($events->each() as $e){
  if($e["event_uid"] == $_GET['eventUid']){
    $event = $e;
  }
}

if(!isset($event)){
  GoBack();
}

include("../header.php"); ?>

<h2><?= $calendar["calendar_name"] ?> - <?= $event["summary"] ?> - Edit</h2>

<div class="well">
  <? if(isset($_GET['errors'])){ ?>
    <div id="error_explanation" class="alert alert-danger">
      <ul>
        <? for($i = 0; $i < count($_GET['errors']); $i++){ ?>
          <li><?= $_GET['errors'][$i] ?></li>
        <? } ?>
      </ul>
    </div>
  <? } ?>

  <form class="form-horizontal" action="/events/update.php" method="post">
    <input type="hidden" value="<?= $calendar["calendar_id"] ?>" name="event[calendar_id]" />
    <input type="hidden" value="<?= $event["event_id"] ?>" name="event[event_id]" />
    <input type="hidden" value="<?= $event["event_uid"] ?>" name="event[event_uid]" />

    <fieldset>
      <div class="form-group">
        <label class="control-label col-lg-2">Event ID</label>
        <div class="col-lg-10">
          <input class="form-control" type="text" name="event[event_id]" value="<?= $event["event_id"] ?>" readonly />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Summary</label>
        <div class="col-lg-10">
          <input class="form-control" type="text" name="event[summary]" value="<?= $event["summary"] ?>" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Description</label>
        <div class="col-lg-10">
          <textarea class="form-control" name="event[description]"><?= $event["description"] ?></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Start Time</label>
        <div class="col-lg-10">
          <input class="form-control" type="datetime-local" name="event[start]" value="<?= substr($event["start"], 0, strlen($event["start"])-4) ?>" />
          <?= $event["start"] ?>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">End Time</label>
        <div class="col-lg-10">
          <input class="form-control" type="datetime-local" name="event[end]" value="<?= substr($event["end"], 0, strlen($event["end"])-4) ?>" />
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-10">
          <input type="submit" value="Update" class="btn btn-success btn-primary" />
        </div>
      </div>
    </fieldset>
  </form>
</div>

<?php include("../footer.php"); ?>
