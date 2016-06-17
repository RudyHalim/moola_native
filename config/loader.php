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

// include all functions inside the folder
foreach (glob("functions/*.php") as $filename) {
    require_once($filename) ;
}

// get the url module action and parameter
$config['url'] = breakUrlFormat($_GET['_url']);

// first landing page is login page
if(!$config['url']['module']) {
    header("Location: /login");
    exit;
}
