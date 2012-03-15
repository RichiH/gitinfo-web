<?php

require("user.inc.php");
require("template.inc.php");

list($status, $url) = $ctl->cmd("templink_get", $_GET['id']);
if ($status == 'ok') {
	header("Location: $url");
}

tpl_header();

?>
<h2>Invalid link</h2>

<p>The link you are visiting is invalid or has expired. Sorry about that.

<?php
tpl_footer();
