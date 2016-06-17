<?php
function flashMsg($text) {
	global $_SESSION;
	$_SESSION['flash_msg'][] = $text;
	return;
}