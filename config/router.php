<?php
// form actions
if(isset($_POST['frmLogin'])) {
    if(checkLogin($_POST['email'], $_POST['password'])) {
        $_SESSION['flash_msg'] = "login success";
        header("Location: /dashboard");
        die;
    } else {
        $_SESSION['flash_msg'] = "login failed";
    }
}


// router
if(isset($config['url']['module'])) {

    // include the view file if any
    $file_to_check = TEMPLATES_PATH.$config['url']['module'].".php";

    include(INCLUDES_PATH."header.php");
    if(file_exists($file_to_check)) {
        require_once($file_to_check);
    } else {
        echo "404";
    }
	include(INCLUDES_PATH."footer.php");

}

?>