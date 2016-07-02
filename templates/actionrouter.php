<?php
// remove unnecessary fields first
if(sizeof($columns) > 0) {
	foreach ($columns as $key => $value) {
		if(isset($value['COLUMN_NAME']) && in_array($value['COLUMN_NAME'], array_keys($automated_columns))) {
			unset($columns[$key]);
		}
	}
}

if(isset($config['url']['action'])) {

	switch ($config['url']['action']) {
		case 'edit':
			include($config['application']['includesDir']."view_edit.php");
			break;
		
		case 'add':
			include($config['application']['includesDir']."view_add.php");
			break;	
		
		case 'search':
			include($config['application']['includesDir']."view_index.php");
			break;	

		default:
			include($config['application']['includesDir']."view_index.php");
			break;
	}
}
