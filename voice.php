<?php

require("user.inc.php");
require("template.inc.php");

tpl_header();
echo "<h2>Get voiced in the channel</h2>\n\n";

echo "<p>Voicing via the web interface is obsolete. Instead, <code>/msg gitinfo .voice</code> on IRC. Thanks!";
tpl_footer();

