<?php

require("user.inc.php");
require("template.inc.php");

list($status, $triggers) = $ctl->cmd("trigger_list");

if ($_GET['json']) {
	header("Content-type: text/plain; charset=UTF-8");
	print $triggers;
	exit;
} elseif ($_GET['tsv']) {
	header("Content-type: text/plain; charset=UTF-8");
	$triggers = json_decode($triggers, true);
	foreach ($triggers as $k => $v) {
		print "$k\t$v\n";
	}
	exit;
}

tpl_header();

$triggers = json_decode($triggers, true);
$aliases = array();
$delete = array();
foreach ($triggers as $k => $v) {
	if (!preg_match("/^@!([a-z_-]+)\$/i", $v, $m)) continue;
	$aliases[$m[1]][] = $k;
	$delete[] = $k;
}
foreach ($delete as $v) { unset($triggers[$v]); }

function format_aliases($t)
{
	global $aliases;
	if (!isset($aliases[$t])) return "";
	$res = $aliases[$t];
	for ($i = 0; $i < count($res); $i++) {
		$res[$i] = "<a href=\"trigger_detail.php?trigger=".  urlencode($res[$i]). "\">!". htmlspecialchars($res[$i]) ."</a>";
	}
	return " (aliases: ". implode(", ", $res) .")";
}

print "<h2>Active triggers</h2>";
if (!$triggers) {
	print "<p>No triggers defined.";
	tpl_footer();
	exit;
}
print "<p>Click on one of the triggers to get its edit history";
if (logged_in()) print " or edit it";
print ". <a href=\"trigger_recent.php\">Global list of recent changes</a><dl>";
foreach ($triggers as $k => $v) {
	$t = htmlspecialchars($k);
	$tu = urlencode($k);
	$a_out = format_aliases($k);
	print "<dt><a href=\"trigger_detail.php?trigger=$tu\">!$t</a>$a_out</dt><dd>".htmlspecialchars($v)."</dd>";
}
print "</dl>";

print <<<EOM
<h2>Raw data</h2>
<p>You can get the raw data as <a href="trigger.php?json=1">JSON</a> or <a
href="trigger.php?tsv=1">tab-separated values (TSV)</a>.
EOM;

tpl_footer();
