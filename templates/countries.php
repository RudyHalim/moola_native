<?php
include($config['application']['includesDir']."menus.php");

?><h1>Countries</h1><?php

if(isset($config['url']['action'])) {

	if($config['url']['action'] == "edit") {

	} else if($config['url']['action'] == "add") {


	} else if($config['url']['action'] == "delete") {

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
