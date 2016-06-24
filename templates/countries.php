<?php
include($config['application']['includesDir']."menus.php");

?><h1>Countries</h1><?php

if(isset($config['url']['action'])) {

	if($config['url']['action'] == "edit") {

		$query = new Query;
		$columns = $query->getColumns('countries');
		$column_id = array_shift($columns);		// move the ID column to another variable

		$query = new Query;
		$query->select = "countries";
		$query->condition->country_id = $config['url']['parameter'];
		$data = $query->execute();

		include($config['application']['includesDir']."view_edit.php");

	} else if($config['url']['action'] == "add") {

		$query = new Query;
		$columns = $query->getColumns('countries');
		$column_id = array_shift($columns);		// move the ID column to another variable
		
		include($config['application']['includesDir']."view_add.php");

	} else if($config['url']['action'] == "delete") {

		$query = new Query;
		$query->delete = "countries";
		$query->condition->country_id = $config['url']['parameter'];
		$success = $query->execute();

		if($success)
			flashMsg("The data has been successfully deleted.");
		else 
			flashMsg("Cannot delete the data.");
		
		header("Location: /".$config['url']['module']);
		die();

	} else if($config['url']['action'] == "search") {

		$query = new Query;
		$query->select = "countries";

		if(isset($_POST['frmFilter'])) {
			unset($_POST['frmFilter']);
			foreach ($_POST as $key => $value) {
				if(!empty($value)) {
					$query->condition->$key = '%'.$value.'%';
				}
			}
		}

		$data = $query->execute();
		include($config['application']['includesDir']."view_index.php");

	} else {

		// index
		$query = new Query;
		$query->select = "countries";

		$data = $query->execute();
		include($config['application']['includesDir']."view_index.php");
	}

}
