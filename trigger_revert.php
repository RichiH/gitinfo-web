<?php

require("user.inc.php");
require("template.inc.php");

if (!$username) die("Be a good boy and log in first.");

$res = $ctl->cmd("trigger_revert", $_POST['tc_id']);

if ($res[0] == "ok") tpl_redirect("trigger.php?ok=1");

tpl_header();
switch ($res[0]) {
case "denied":
	print "<p>You are not allowed to edit triggers, sorry.";
	break;
case "doesntexist":
	print "<p>You tried to edit a trigger that doesn't exist. If you want to add a new trigger, please do so on IRC (if you are allowed to).";
	break;
case "locked":
	print "<p>This trigger is locked against edits. You need special privileges in order to edit it.";
	break;
default:
	print "<p>Something unknown and confusing happened and your edit didn't go through (". implode(',', $res) ."). Sorry!";
}
tpl_footer();

