<?php include("../header.php");

if(!isset($_GET['calendarId'])){
  header('Location: ' . $globals['DOMAIN'] . '/profiles');
}

$calendars = $cronofy->list_calendars()["calendars"];

for($i = 0; $i < count($calendars); $i++){
  if($calendars[$i]["calendar_id"] == $_GET['calendarId']){
    $calendar = $calendars[$i];
  }
}

if(!isset($calendar)){
  header('Location: ' . $globals['DOMAIN'] . '/profiles');
}

$events = $cronofy->read_events(array("tzid" => "Etc/UTC", "include_managed" => true, "calendar_ids" => array($calendar["calendar_id"])));
?>

<h2><?= $calendar["calendar_name"] ?> - Events</h2>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Event Summary</th>
      <th>Start</th>
      <th>End</th>
      <th></th>
    </tr>
  </thead>

  <tbody>
    <? foreach($events->each() as $event){ ?>
    <tr>
      <td>
        <?= $event["summary"] ?>
      </td>
      <td>
        <?= $event["start"] ?>
      </td>
      <td>
        <?= $event["end"] ?>
      </td>
      <td>
        <a href="/events/show.php?event_uid=<?= $event["event_uid"] ?>">
          View
        </a>
      </td>
    </tr>
    <? } ?>
  </tbody>
</table>

<?php include("../footer.php"); ?>
