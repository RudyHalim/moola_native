<?php
// form actions
if(isset($_POST['frmLogin'])) {

    $login_user_id = getUserIdByLogin($_POST['email'], $_POST['password']);

    if( $login_user_id > 0) {
        
        $_SESSION['flash_msg'] = "Login Success";
        $_SESSION['user_id'] = $login_user_id;
        
        header("Location: ".$config['application']['baseUri']."dashboard");
        die;
    } else {
        $_SESSION['flash_msg'] = "Invalid Login";
    }
}

if(isset($_POST['frmProfile'])) {
    
    if(isset($_SESSION['user_id'])) {

        $query = new Query();
        $query->update = 'users';
        $query->data->email_addr    = $_POST['email_addr'];
        $query->data->first_name    = $_POST['first_name'];
        $query->data->last_name     = $_POST['last_name'];
        $query->condition->user_id  = $_SESSION['user_id'];
        $query->execute();

        $_SESSION['flash_msg'] = $query->flash_msg;

    } else {
        header("Location: ".$config['application']['baseUri']);
        die;
    }

}
