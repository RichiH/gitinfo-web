<?php

require("user.inc.php");
require("template.inc.php");

setcookie("gitinfo_sessionid");
$prev_username = $username;
$username = NULL;

tpl_header();

print "<h2>Logout</h2>";
if ($prev_username)
	print "<p>Bye, $prev_username! See you! Now <a href=\"index.html\">go
	back to the main page</a> or something.";
else
	print "<p>No need to log out when you're not logged in...";

tpl_footer();

