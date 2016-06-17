<?php
// form actions
if(isset($_POST['frmLogin'])) {
    
    $login_user_id = getUserIdByLogin($_POST['email'], $_POST['password']);
    
    if( $login_user_id > 0) {
        
        $_SESSION['flash_msg'] = "login success";
        $_SESSION['user_id'] = $login_user_id;
        
        header("Location: /dashboard");
        die;
    } else {
        $_SESSION['flash_msg'] = "login failed";
    }
}

if(isset($_POST['frmProfile'])) {
    
    if(isset($_SESSION['user_id'])) {

    } else {
    	header("Location: /");
        die;
    }

}
?>