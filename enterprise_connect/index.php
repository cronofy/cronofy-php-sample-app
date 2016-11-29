<?php
include("./config.php");

if($cronofy->access_token != ""){
  $resources = $cronofy->resources()["resources"];

  $users = Array();

  $usersFolder = __DIR__ . "/users/";
  if(file_exists($usersFolder)){
    $userFiles = scandir($usersFolder);

    for($i = 0; $i < count($userFiles); $i++){
      if($userFiles[$i] == "." || $userFiles[$i] == "..")
        continue;

      $userFile = fopen($usersFolder . $userFiles[$i], "r");
      $userData = json_decode(fread($userFile, filesize($usersFolder . $userFiles[$i])), true);

      array_push($users, $userData);
    }
  }
}

include("../header.php");
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

  <h3>Users</h3>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Name</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <? for($i = 0; $i < count($users); $i++){ ?>
        <tr>
          <td><?= $users[$i]["email"] ?></td>
          <td><?= $users[$i]["status"] ?></td>
          <td>
            <? if($users[$i]["status"] == "Linked"){ ?>
              <a href="/service_account_users/?email=<?= $users[$i]["email"] ?>">
                View
              </a>
            <? } ?>
          </td>
        </tr>
      <? } ?>
    </tbody>
  </table>
  <? }

include("../footer.php");
?>
