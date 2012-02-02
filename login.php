<?php

require("user.inc.php");
require("template.inc.php");

tpl_header();

if (!$login): ?>
<h2>Login failed</h2>
<p>Sorry, but for reasons unknown (or displayed above), you could not be logged in.
<?php
	tpl_footer();
	exit;
endif;

print <<<EOS
<h2>Login succeeded</h2>
<p>Hi $username, nice to have you here! Why don't you go back to the <a
href="index.html">main page</a> and use the functions listed there. I've added
some extra options for you.
EOS;
tpl_footer();
