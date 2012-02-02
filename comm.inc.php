<?php

require('config.inc.php');

class ctl_socket {
	private $sock;

	function __construct()
	{
		$this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$res = socket_connect($this->sock, CTL_IP, CTL_PORT);
		if ($res === false) {
			die("Failed connecting to bot, reason: ". socket_strerror(socket_last_error($this->sock)));
		}
	}

	function send()
	{
		$args = array();
		foreach (func_get_args() as $a) {
			$args[] = str_replace(array("%", ":", "\015", "\012"), array("%25", "%3A", "%0D", "%0A"), $a);
		}
		socket_write($this->sock, implode(":", $args)."\012");
	}

	function recv()
	{
		$data = socket_read($this->sock, 1048576, PHP_NORMAL_READ);
		if ($data === false) {
			die("Bot communication error: ". socket_strerror(socket_last_error($this->sock)));
		}
		$args = explode(":", trim($data));
		while (list($k, $v) = each($args)) {
			$args[$k] = rawurldecode($v);
		}
		return $args;
	}

	function cmd()
	{
		call_user_func_array(array($this, "send"), func_get_args());
		return $this->recv();
	}
}

$ctl = new ctl_socket();
