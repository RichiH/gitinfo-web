<?php

require("user.inc.php");
require("template.inc.php");

list($status, $hist) = $ctl->cmd("trigger_history", $_GET['trigger']);

if ($_GET['json']) {
	header("Content-type: text/plain; charset=UTF-8");
	print $hist;
	exit;
} elseif ($_GET['tsv']) {
	header("Content-type: text/plain; charset=UTF-8");
	$hist = json_decode($hist, true);
	foreach ($hist as $v) {
		print "$v[exp]\t$v[changed_by]\t$v[changed_at]\n";
	}
	exit;
}

tpl_header();

$hist = json_decode($hist, true);
if (!$hist) {
	print "<p>Trigger isn't currently defined.";
	tpl_footer();
	exit;
}
if ($username):
	print "<h2>Edit !$_GET[trigger]</h2>\n";
	$exp = htmlspecialchars($hist[0]['exp']);
	print <<<EOF
<form method="post" action="trigger_edit.php">
<p>Content:<br><input name="exp" value="$exp" size="100" maxlength="400"><br>
<input type="hidden" name="trigger" value="$_GET[trigger]">
<input type="submit" value="Edit">
</form>
EOF;
endif;

print "<h2>History of !$_GET[trigger]</h2>\n";
print "<ul>\n";
$first = true;
foreach ($hist as $h) {
	print "<li>$h[exp]<br>By $h[changed_by] at $h[changed_at]";
	if (!$first && $username) print <<<EOF
 <form style="display: inline;" method="post" action="trigger_revert.php"><input type="hidden" name="tc_id" value="$h[tc_id]"><input type="submit" value="Restore this version"></form>
EOF;
	print "\n";
	$first = false;
}
print "</ul>\n";
tpl_footer();
