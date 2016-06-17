<?php
// form actions
if(isset($_POST['frmLogin'])) {

    $login_user_id = getUserIdByLogin($_POST['email'], $_POST['password']);

    if( $login_user_id > 0) {
        
        flashMsg("Login Success");

        $_SESSION['user_id'] = $login_user_id;
        
        header("Location: ".$config['application']['baseUri']."dashboard");
        die;
    } else {
        flashMsg("Invalid Login");
    }
}

if(isset($_POST['frmProfile'])) {
    
    if(isset($_SESSION['user_id'])) {

        if(isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['newpassword']) && isset($_POST['newpassword1'])) {
            if($_POST['newpassword'] == $_POST['newpassword1']) {
                $query = new Query();
                $query->update = 'users';
                $query->data->passwd = md5($_POST['newpassword']);
                $query->condition->user_id  = $_SESSION['user_id'];
                $query->condition->passwd = md5($_POST['password']);
                $query->execute();

                if(mysqli_affected_rows($mysqli) > 0) {
                    flashMsg("Your new password has been updated.");
                } else {
                    flashMsg("Old Password do not match");
                }
            } else {
                flashMsg("New Password do not match");
            }
        }

        $query = new Query();
        $query->update = 'users';
        $query->data->email_addr    = $_POST['email_addr'];
        $query->data->first_name    = $_POST['first_name'];
        $query->data->last_name     = $_POST['last_name'];
        $query->data->is_active     = $_POST['is_active'];
        $query->data->gender        = $_POST['gender'];
        $query->data->phone_no      = $_POST['phone_no'];
        $query->data->display_image = $_POST['display_image'];
        $query->data->country_id    = $_POST['country_id'];
        $query->data->role_id       = $_POST['role_id'];
        $query->condition->user_id  = $_SESSION['user_id'];
        $query->execute();

        flashMsg($query->flash_msg);

    } else {
        header("Location: ".$config['application']['baseUri']);
        die;
    }

}
