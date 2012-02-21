<?php

require("user.inc.php");
require("template.inc.php");

tpl_header();
echo "<h2>Get voiced in the channel</h2>\n\n";

if ($_POST['nick'] && !$_POST['captcha']) {
	$res = $ctl->cmd("voice", $_POST['nick']);
	if ($res[0] == "ok") {
		echo "<p>Thanks, you should now be able to talk in the channel.";
	} else {
		echo "<p>Sorry, that didn't work: $res[2]";
	}
	tpl_footer();
	exit;
}

print <<<EOF
<p>Please complete the form below to get cleared for talking in the channel...
or register with and log into NickServ on IRC.

<form method="post" action="voice.php">
<p>Your IRC nick: <input name="nick" value="" size="64" maxlength="64"><br>
Leave this field blank: <input name="captcha" value="">
<input type="submit" value="Request voice">
</form>
EOF;

tpl_footer();

