<?php
include($config['application']['includesDir']."menus.php");

echo "<h1>".ucwords(str_replace("_", " ", $crud_table_name))."</h1>";

$columns = array();
if(isset($config['url']['action'])) {

	if($config['url']['action'] == "edit") {

		$query = new Query;
		$columns = $query->getColumns($crud_table_name);

		$query = new Query;
		$query->select = $crud_table_name;
		$query->condition->$crud_primary_key = $config['url']['parameter'];
		$data = $query->execute();

	} else if($config['url']['action'] == "add") {

		$query = new Query;
		$columns = $query->getColumns($crud_table_name);
		$column_id = array_shift($columns);		// move the ID column to another variable

	} else if($config['url']['action'] == "delete") {

		$query = new Query;
		$query->delete = $crud_table_name;
		$query->condition->$crud_primary_key = $config['url']['parameter'];
		$success = $query->execute();

		if($success)
			flashMsg("The data has been successfully deleted.");
		else 
			flashMsg("Cannot delete the data.");

		header("Location: /".$config['url']['module']);
		die();

	} else if($config['url']['action'] == "search") {

		$pagination = new Pagination;
		$query = new Query;
		$query->select = $crud_table_name;

		// search need this filter coming along
		if(isset($_POST['frmFilter'])) {
			unset($_POST['frmFilter']);
			$_SESSION['filterCond'] = $_POST;
		}

		if(isset($_SESSION['filterCond'])) {
			foreach ($_SESSION['filterCond'] as $key => $value) {
				if(!empty($value)) {

					if($key == "country_id") {
						$query->condition->$key = getListCountryIdSearchByName($value);
					} else if($key == "role_id") {
						$query->condition->$key = getListRoleIdSearchByName($value);
					} else if(in_array($key, array('created_by', 'updated_by'))) {
						$query->condition->$key = implode(", ", getListUserIdSearchByName($value));
					} else {
						$query->condition->$key = '%'.$value.'%';
					}

				}
			}
		}

		// -------------------------------------------------
		// pagination script
		$query->execute();	// must execute to get total rows
		if(isset($config['url']['querystring']['page'])) {
			$pagination->page = $config['url']['querystring']['page'];
		}
		$pagination->totalRows = $query->getTotalRows();
		$pagination->calculate();
		$query->limit = $pagination->generateLimitQuery();
		// end of pagination script
		// -------------------------------------------------

		$data = $query->execute();

	} else {

		unset($_SESSION['filterCond']);

		$pagination = new Pagination;
		$query = new Query;
		$query->select = $crud_table_name;

		// -------------------------------------------------
		// pagination script
		$query->execute();	// must execute to get total rows
		if(isset($config['url']['querystring']['page'])) {
			$pagination->page = $config['url']['querystring']['page'];
		}
		$pagination->totalRows = $query->getTotalRows();
		$pagination->calculate();
		$query->limit = $pagination->generateLimitQuery();
		// end of pagination script
		// -------------------------------------------------

		$data = $query->execute();
	}

}
