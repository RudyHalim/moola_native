<?php
include($config['application']['templatesDir']."crud.php");

if($config['url']['action'] == "") {
	foreach ($data as $key => $value) {
		unset($data[$key]['page_content']);	// do not show page content field on list view
	}
}

include($config['application']['templatesDir']."actionrouter.php");
?>