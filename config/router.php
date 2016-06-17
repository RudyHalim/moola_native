<?php
// form redirects before load any module
include($config['application']['configDir']."formrouter.php");

// router to load module
if(isset($config['url']['module'])) {

    if($config['url']['module'] == "logout") {
        unset($_SESSION);
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
