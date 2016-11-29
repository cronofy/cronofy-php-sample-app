<?php
include("../config.php");

$calendars = $cronofy->list_calendars()["calendars"];

include("../header.php"); ?>

<h2>New Channel</h2>

<div class="well">
  <form class="form-horizontal" action="/channels/create.php" method="post">
    <fieldset>
      <div class="form-group">
        <label class="control-label col-lg-2">Calendar Path</label>
        <div class="col-lg-10">
          <div class="col-xs-5 col-sm-4 col-md-3 text-right" style="margin-top: 8px"><?= $GLOBALS['DOMAIN'] ?>/push/?path=</div>
          <div class="col-xs-7 col-sm-8 col-md-9">
            <input type="text" name="channel[path]" class="form-control" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Interested Events</label>
        <div class="col-lg-10 checkbox">
          <label>
            <input type="hidden" name="channel[only_managed]" value="0" />
            <input type="checkbox" name="channel[only_managed]" />
            Only Managed
          </label>
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-lg-2">Interested Calendars</label>
        <div class="col-lg-10">
          <input type="hidden" name="channel[calendar_ids][]" value="" />
          <? for($i = 0; $i < count($calendars); $i++){ ?>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="<?= $calendars[$i]["calendar_id"] ?>" name="channel[calendar_ids][]" checked />
                <?= $calendars[$i]["profile_name"] ?> - <?= $calendars[$i]["calendar_name"] ?>
              </label>
            </div>
          <? } ?>
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
