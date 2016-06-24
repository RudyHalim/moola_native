<?php
include($config['application']['includesDir']."menus.php");

echo "<h1>".ucwords($crud_table_name)."</h1>";

if(isset($config['url']['action'])) {

	if($config['url']['action'] == "edit") {

		$query = new Query;
		$columns = $query->getColumns($crud_table_name);

		$query = new Query;
		$query->select = $crud_table_name;
		$query->condition->$crud_primary_key = $config['url']['parameter'];
		$data = $query->execute();

		include($config['application']['includesDir']."view_edit.php");

	} else if($config['url']['action'] == "add") {

		$query = new Query;
		$columns = $query->getColumns($crud_table_name);
		$column_id = array_shift($columns);		// move the ID column to another variable
		
		include($config['application']['includesDir']."view_add.php");

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
					$query->condition->$key = '%'.$value.'%';
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
		include($config['application']['includesDir']."view_index.php");

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
		include($config['application']['includesDir']."view_index.php");
	}

}
