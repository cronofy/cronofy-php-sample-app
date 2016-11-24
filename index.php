<?php include("header.php"); ?>

<? if($cronofy->access_token == "") { ?>
<a class="btn btn-primary btn-success" href="/oauth/">
  Login
</a>
<? } else { ?>
  <a href="/profiles.php">Account Profiles</a>
  <br />
  Channels
  <br />
  Free busy
  <br />
  Enterprise Connect
<? } ?>

<?php include("footer.php"); ?>
