<?php
$mysqli = new mysqli($config['database']['host'], $config['database']['username'], $config['database']['password'], $config['database']['dbname']);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// start session before manipulate data
session_start();

// prevent XSS
$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

// include all libraries inside the folder
foreach (glob("library/*.php") as $filename) {
    require_once($filename) ;
}

// get the url module action and parameter
$config['url'] = breakUrlFormat($_GET);

// first landing page is login page
if(!$config['url']['module']) {
    header("Location: /login");
    exit;
}

// defined columns' default values only, empty for mysql default value
$automated_columns = array(
		'created_dt' => 'NOW()', 
		'created_by' => $_SESSION['user_id'] ? $_SESSION['user_id'] : 0 , 
		'updated_dt' => 'NOW()', 
		'updated_by' => $_SESSION['user_id'] ? $_SESSION['user_id'] : 0 
	);

// load the model
$model = new Model;
if(isset($model->table->$config['url']['module'])) {
	$crud_table_name 		= $model->table->$config['url']['module']->name;
	$crud_primary_key 		= $model->table->$config['url']['module']->primary;
	$crud_unique_fields 	= $model->table->$config['url']['module']->unique;
	$crud_automated_fields 	= $model->table->$config['url']['module']->trackingUpdated ? $automated_columns : array();
}
