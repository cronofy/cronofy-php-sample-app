<?php
$GLOBALS['SKIP_AUTH'] = true;

include("globals.php");
include("header.php");
?>

<? if($cronofy->access_token == "") { ?>
<a class="btn btn-primary btn-success" href="/oauth/">
  Login
</a>
<? } else { ?>
  <a href="/profiles/">Account Profiles</a>
  <br />
  <a href="/channels/">Channels</a>
  <br />
  Free busy
  <br />
  Enterprise Connect
<? } ?>

<?php include("footer.php"); ?>
