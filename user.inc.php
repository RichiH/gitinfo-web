<?php

require("comm.inc.php");

$username = NULL;
$session_expired = false;

function logged_in()
{
	return $GLOBALS['username'];
}

function do_login()
{
	global $ctl, $username, $session_expired;

	$session_id = $_GET['session_id'];
	if (!$session_id) $session_id = $_COOKIE['gitinfo_sessionid'];
	if (!$session_id) return false;

	list($res, $arg) = $ctl->cmd("login", $session_id);

	switch ($res) {
	case "invalid":
		setcookie('gitinfo_sessionid');
		print <<<EOT
<!DOCTYPE HTML>
<html><body><p>Invalid session. Please <a href="index.html">go elsewhere</a> or retry or something.</body></html>
EOT;
		exit;
	case "expired":
		$session_expired = true;
		return false;
	default:
		// Currently, no other responses defined except "ok"
		break;
	}

	if ($_COOKIE["gitinfo_sessionid"] != $session_id) setcookie("gitinfo_sessionid", $session_id);
	$username = $arg;
	return true;
}

$login = do_login();

