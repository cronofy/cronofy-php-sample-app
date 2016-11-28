<?php
include("./globals.php");

include("../header.php");

if($cronofy->access_token != ""){
  $resources = $cronofy->resources()["resources"];
}
?>

<div class="row">
  <div class="col-xs-8">
    <h2>Enterprise Connect</h2>
  </div>

<? if($cronofy->access_token != ""){ ?>
  <div class="col-xs-4 text-right">
    <a href="/enterprise_connect/new.php" class="btn btn-primary btn-success">
      Authorize User
    </a>
  </div>
<? } ?>
</div>

<? if($cronofy->access_token == ""){ ?>
  <a class="btn btn-primary btn-success" href="/enterprise_connect/oauth/">
    Log in with your Admin account
  </a>
<? } else {

?>
  <h3>Resources</h3>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
      </tr>
    </thead>

    <tbody>
      <? for($i = 0; $i < count($resources); $i++){ ?>
        <tr>
          <td><?= $resources[$i]["name"] ?></td>
          <td><?= $resources[$i]["email"] ?></td>
        </tr>
      <? } ?>
    </tbody>
  </table>
  <? } ?>
