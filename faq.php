<?php

require("user.inc.php");
require("template.inc.php");

tpl_header();

print "<h2>FAQ entries:</h2>";
list($status, $faq) = $ctl->cmd("faq_list");
$faq = json_decode($faq, true);
if (!$faq) {
	print "<p>No FAQ entries are known.";
	tpl_footer();
	exit;
}
print "<ul>";
foreach ($faq as $k => $v) {
	if ($v) $v = ": $v";
	print "<li><strong>".htmlspecialchars($k)."</strong>".htmlspecialchars($v);
}
print "</ul>";
tpl_footer();
