<?php

require("user.inc.php");
require("template.inc.php");

list($status, $data) = $ctl->cmd("trigger_recentchanges");

tpl_header();

$data = json_decode($data, true);

print "<h2>Recent changes to triggers</h2>";
if (!$data) {
	print "<p>No changes recorded yet.";
	tpl_footer();
	exit;
}
print "<p>Click on one of the triggers to get its edit history";
if (logged_in()) print " or edit it";
print ".<dl>";
foreach ($data as $v) {
	$t = htmlspecialchars($v['trigger']);
	$tu = urlencode($v['trigger']);
	print "<dt><a href=\"trigger_detail.php?trigger=$tu\">!$t</a></dt><dd>".htmlspecialchars($v['exp'])."<em> -- $v[changed_by] at $v[changed_at]</em></dd>";
}
print "</dl>";

tpl_footer();
