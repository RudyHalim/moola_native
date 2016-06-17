<?php
defined('APP_PATH')         || define('APP_PATH', realpath('.'));

$config = array(
    'database' => array(
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => 'ruxd',
        'dbname'      => 'db_moola'
    ),
    'application' => array(
        'configDir'         => APP_PATH.'/config/',
        'templatesDir'      => APP_PATH.'/templates/',
        'includesDir'       => APP_PATH.'/templates/inc/',
        'uploadDir'         => 'images/uploads/',
        'displayImageDir'   => 'images/uploads/display_image/',
        'baseUri'           => '/'
    )
);
