<?php
include($config['application']['templatesDir']."crud.php");

if(sizeof($data) > 0) {
	foreach ($data as $key => $value) {
		$created[$key] = $value['created_dt'];
		$seller_value[$key] = $value['seller_value'];
	}
	array_multisort($created, SORT_DESC, $seller_value, SORT_DESC, $data);
}

include($config['application']['templatesDir']."actionrouter.php");
?>