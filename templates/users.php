<?php
include($config['application']['templatesDir']."crud.php");

if(in_array($config['url']['action'], array("", "search"))) {
	foreach ($data as $key => $value) {
		unset($data[$key]['passwd']);
		unset($data[$key]['display_image']);
	}
}

include($config['application']['templatesDir']."actionrouter.php");
?>