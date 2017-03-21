<?php
include("../config.php");

if(!isset($_GET['profileId'])){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/profiles/');
  die;
}

$profiles = $cronofy->get_profiles()["profiles"];

for($i = 0; $i < count($profiles); $i++){
  if($profiles[$i]["profile_id"] == $_GET['profileId']){
    $profile = $profiles[$i];
  }
}

if(!isset($profile)){
  header('Location: ' . $GLOBALS['DOMAIN'] . '/profiles/');
  die;
}

include("../header.php"); ?>

<h2><?= $profile["profile_name"] ?> - New Calendar</h2>

<div class="well">
  <?= ServerErrorBlockFromGet(); ?>

  <? if(isset($_GET['errors'])){ ?>
    <div id="error_explanation" class="alert alert-danger">
      <ul>
        <? for($i = 0; $i < count($_GET['errors']); $i++){ ?>
          <li><?= $_GET['errors'][$i] ?></li>
        <? } ?>
      </ul>
    </div>
  <? } ?>

  <form class="form-horizontal" action="/calendars/create.php" method="post">
    <input type="hidden" value="<?= $profile["profile_id"] ?>" name="calendar[profile_id]" />

    <fieldset>
      <div class="form-group">
        <label class="control-label col-lg-2">Calendar Name</label>
        <div class="col-lg-10">
          <input class="form-control" type="text" name="calendar[name]" />
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

<?php include("../footer.php"); ?>
