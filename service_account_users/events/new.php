<?php
include("../config.php");

if(!isset($_GET['calendarId'])){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/service_account_users/show.php?email=' . $_GET['email']);
  die;
}

$calendars = $cronofy->list_calendars()["calendars"];

for($i = 0; $i < count($calendars); $i++){
  if($calendars[$i]["calendar_id"] == $_GET['calendarId']){
    $calendar = $calendars[$i];
  }
}

if(!isset($calendar)){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/profiles/');
  die;
}

include("../../header.php"); ?>

<h2><?= $calendar["calendar_name"] ?> - New Event</h2>

<div class="well">
  <form class="form-horizontal" action="/service_account_users/events/create.php" method="post">
    <input type="hidden" value="<?= $calendar["calendar_id"] ?>" name="event[calendar_id]" />
    <input type="hidden" value="<?= $_GET['email'] ?>" name="email" />

    <fieldset>
      <div class="form-group">
        <label class="control-label col-lg-2">Event ID</label>
        <div class="col-lg-10">
          <input class="form-control" type="text" name="event[event_id]" value="unique_event_id_<?= mt_rand(1000000,9999999) ?>" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Summary</label>
        <div class="col-lg-10">
          <input class="form-control" type="text" name="event[summary]" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Description</label>
        <div class="col-lg-10">
          <textarea class="form-control" name="event[description]"></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Start Time</label>
        <div class="col-lg-10">
          <input class="form-control" type="datetime-local" name="event[start]" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">End Time</label>
        <div class="col-lg-10">
          <input class="form-control" type="datetime-local" name="event[end]" />
        </div>
      </div>

      <div class="form-group">
        <div class="col-lg-10">
          <input type="submit" value="Create" class="btn btn-success btn-primary" />
        </div>
      </div>
    </fieldset>
  </form>
</div>

<?php include("../../footer.php"); ?>
