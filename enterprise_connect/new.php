<?php
include("./config.php");

include("../header.php");
?>

<h2>Enterprise Connect - User Authorization</h2>

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

  <form class="form-horizontal" action="create.php" method="post">
    <fieldset>
      <div class="form-group">
        <label class="control-label col-lg-2">User Email</label>
        <div class="col-lg-10">
          <input type="text" name="user[email]" class="form-control" />
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Scopes</label>
        <div class="col-lg-10">
          <input type="text" name="user[scope]" class="form-control" value="read_account list_calendars read_events create_event delete_event read_free_busy" />
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

<? include("../footer.php");
