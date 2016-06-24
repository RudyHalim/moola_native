<?php
// form redirects before load any module
include($config['application']['configDir']."formrouter.php");

// router to load module
if(isset($config['url']['module'])) {

    if($config['url']['module'] == "logout") {
        session_destroy();
        header("Location: /");
        die;
    }
    if(!isset($_SESSION['user_id']) && $config['url']['module'] != "login") {
        header("Location: /");
        die;
    }

    // include the view file if any
    $file_to_check = $config['application']['templatesDir'].$config['url']['module'].".php";

    include($config['application']['includesDir']."header.php");
    if(file_exists($file_to_check)) {
        require_once($file_to_check);
    } else {
        echo "404";
    }
    include($config['application']['includesDir']."footer.php");

}
