<?php

require("user.inc.php");
require("template.inc.php");

if (!$username) die("Be a good boy and log in first.");

list($status, $arg) = $ctl->cmd("trigger_edit", $_POST['trigger'], $_POST['exp']);

if ($status == "ok") tpl_redirect("trigger.php?ok=1");

tpl_header();
switch ($status) {
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
	print "<p>Something unknown and confusing happened and your edit didn't go through ($status, $arg). Sorry!";
}
tpl_footer();
