<?php

error_reporting(E_ALL);

define('APP_PATH', realpath('.'));

try {

    /**
     * Read the configuration
     */
    include APP_PATH . "/config/config.php";

    /**
     * Read auto-loader
     */
    include APP_PATH . "/config/loader.php";

    /**
     * Read routers
     */
    include APP_PATH . "/config/router.php";

} catch (Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
