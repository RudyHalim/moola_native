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

        if(isset($_FILES['display_image']) && $_FILES['display_image']['size'] > 0) {
            $imagePath = uploadDisplayImage($_FILES["display_image"]);
            if(!empty($imagePath)) {

                // delete old image
                $picquery = new Query;
                $picquery->select = "users";
                $picquery->fields = "display_image";
                $picquery->condition->user_id = $_SESSION['user_id'];

                $picresult = $picquery->execute();
                if($picresult) {
                    $oldimage = $picresult[0]['display_image'];
                    if(file_exists($oldimage)) {
                        unlink($oldimage);
                    }
                }

                // update the data with new image
                $query->data->display_image = $imagePath;
            }
        }

        $query->data->email_addr    = $_POST['email_addr'];
        $query->data->first_name    = $_POST['first_name'];
        $query->data->last_name     = $_POST['last_name'];
        $query->data->is_active     = $_POST['is_active'];
        $query->data->gender        = $_POST['gender'];
        $query->data->phone_no      = $_POST['phone_no'];
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

if(isset($_POST['frmAdd'])) {
    $q = new Query;
    $q->insert = 'countries';
    $q->data->country_name      = $_POST['country_name'];
    $q->data->country_currency  = $_POST['country_currency'];
    $q->data->country_trade     = $_POST['country_trade'];
    $q->data->markup_value      = $_POST['markup_value'];
    $q->execute();
    flashMsg($q->flash_msg);
    unset($_POST);
}

if(isset($_POST['frmEdit'])) {
    $q = new Query;
    $q->update = 'countries';
    $q->data->country_name      = $_POST['country_name'];
    $q->data->country_currency  = $_POST['country_currency'];
    $q->data->country_trade     = $_POST['country_trade'];
    $q->data->markup_value      = $_POST['markup_value'];
    $q->execute();
    flashMsg($q->flash_msg);
    unset($_POST);
}
