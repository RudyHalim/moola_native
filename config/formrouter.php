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

if(isset($_SESSION['user_id'])) {
    if(isset($_POST['frmAdd'])) {
        // check existance
        $proceed = true;

        if(sizeof($crud_unique_fields) > 0) {
            $check = new Query;
            $check->select = $crud_table_name;
            foreach ($crud_unique_fields as $key => $value) {
                $check->condition->$value = $_POST[$value];
            }
            $check_result = $check->execute();
            $proceed = sizeof($check_result) == 0 ? true : false;
        }

        if($proceed) {
            $q = new Query;
            $q->insert = $crud_table_name;

            if(isset($_FILES['display_image']) && $_FILES['display_image']['size'] > 0) {
                $imagePath = uploadDisplayImage($_FILES["display_image"]);
                if(!empty($imagePath)) {
                    // update the data with new image
                    $q->data->display_image = $imagePath;
                }
            }

            unset($_POST['frmAdd']);
            foreach ($_POST as $key => $value) {
                if($key == "passwd") {
                    $value = !empty($value) ? $value : "1234";
                    $q->data->$key = md5($value);
                } else {
                    $q->data->$key = $value;
                }
            }

            // recording updated date time fields
            if(sizeof($crud_automated_fields) > 0) {

                // define the automated field in this action
                $field_automated = array('created_by', 'created_dt');
                
                foreach ($crud_automated_fields as $key => $value) {
                    if(in_array($key, $field_automated)) {
                        $q->data->$key      = $value;
                    }
                }
            } 

            $q->execute();
            flashMsg($q->flash_msg);

        } else {
            flashMsg("Record already exists.");
        }
        unset($_POST);
    }

    if(isset($_POST['frmEdit'])) {

        $q = new Query;
        $q->update = $crud_table_name;

        if(isset($_FILES['display_image']) && $_FILES['display_image']['size'] > 0) {
            $imagePath = uploadDisplayImage($_FILES["display_image"]);
            if(!empty($imagePath)) {

                // delete old image
                $picquery = new Query;
                $picquery->select = $crud_table_name;
                $picquery->fields = "display_image";
                $picquery->condition->$crud_primary_key   = $_POST[$crud_primary_key];

                $picresult = $picquery->execute();
                if($picresult) {
                    $oldimage = $picresult[0]['display_image'];
                    if(file_exists($oldimage)) {
                        unlink($oldimage);
                    }
                }

                // update the data with new image
                $q->data->display_image = $imagePath;
            }
        }

        if(isset($_POST[$crud_primary_key])) {
            $q->condition->$crud_primary_key   = $_POST[$crud_primary_key];
            unset($_POST[$crud_primary_key]);
        }

        unset($_POST['frmEdit']);
        foreach ($_POST as $key => $value) {
            if($key == "passwd") {
                if(!empty($value)) 
                    $q->data->$key = md5($value);
            } else {
                $q->data->$key = $value;
            }
        }

        if(isset($_POST['passwd']) && !empty($_POST['passwd'])) {
            $q->data->passwd = md5($_POST['passwd']);
        }

        // recording updated date time fields
        if(sizeof($crud_automated_fields) > 0) {

            // define the automated field in this action
            $field_automated = array('updated_by', 'updated_dt');
            
            foreach ($crud_automated_fields as $key => $value) {
                if(in_array($key, $field_automated)) {
                    $q->data->$key      = $value;
                }
            }
        } 

        $q->execute();
        flashMsg($q->flash_msg);
        unset($_POST);
    }
}
