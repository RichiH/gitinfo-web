<?php

function tpl_redirect($path)
{
	header("Location: http://jk.gs/git/bot/$path");
	exit;
}

function tpl_header()
{
	print <<<EOT
<!DOCTYPE HTML>
<html><head><title>#git bot interface</title>
<link rel="stylesheet" type="text/css" href="../style.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head><body>
<h1>#git bot interface</h1>
EOT;
	if ($user = logged_in()) {
		print <<<EOT
<div id="login_menu">Hi <strong>$user</strong>. <a href="logout.php">Log
out</a> or go do fun stuff.</div>
EOT;
	}
	if ($_GET['ok']) {
		print "<div id=\"msg\">Operation successful. Yay!</div>";
	}
}

function tpl_footer()
{
	print <<<EOT
</body></html>
EOT;
}
