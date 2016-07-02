<?php
function getUserIdByLogin($email, $password) {
    $user_id = 0;

    $query = new Query();
    $query->select = 'users';
    $query->fields = 'user_id';
    $query->condition->email_addr = $email;
    $query->condition->passwd = md5($password);
    $query->condition->is_active = 'Y';
    $query->limit = 1;
    
    $result = $query->execute();
    
    if($result) {
        $user_id = $result[0]['user_id'];
    }

    return $user_id;
}

function getUserDataByUserId($user_id) {
    $query = new Query;
    $query->select = 'users';
    $query->condition->user_id = $user_id;
    $query->limit= 1;
    
    $result = $query->execute();
    if($result)
        return $result;

    return 0;
}

function getUserNameByUserId($user_id) {
    $user_data = getUserDataByUserId($user_id);
    return $user_data[0]['first_name']." ".$user_data[0]['last_name'];
}

function generateSelectOptions($array, $selected="") {
    $result = "";
    if(is_array($array) && sizeof($array) > 0) {
        foreach ($array as $key => $value) {
            $isselected = $key == $selected ? "selected" : "";
            $result .= "<option value='".$key."' ".$isselected.">".$value."</option>";
        }
    }
    return $result;
}

function generateCbYesNo($selected) {
    $array = array("Y" => "Yes", "N" => "No");
    return generateSelectOptions($array, $selected);
}

function generateCbGender($selected) {
    $array = array("male" => "Male", "female" => "Female");
    return generateSelectOptions($array, $selected);
}

function uploadDisplayImage($file) {
    global $config;

    $prefix_file    = date("Y-m-d_H:i:s")."_".sha1(microtime(true).mt_rand(10000,90000))."_";
    $target_file    = $config['application']['displayImageDir'].$prefix_file.basename($file["name"]);
    $imageFileType  = pathinfo($target_file,PATHINFO_EXTENSION);

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        // flashMsg("File is an image - " . $check["mime"] . ".");
        $uploadOk = 1;
    } else {
        // flashMsg("File is not an image.");
        $uploadOk = 0;
    }

    if ($file["size"] > 500000) {
        flashMsg("Sorry, your file is too large.");
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        flashMsg("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        flashMsg("Sorry, your file was not uploaded.");
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            flashMsg("The file ". basename( $file["name"]). " has been uploaded.");
            return $target_file;
        } else {
            flashMsg("Sorry, there was an error uploading your file.");
        }
    }
    return "";
}

function getListUserIdSearchByName($user_name) {
    $query = new Query;
    $query->select = "users";
    $query->fields = "user_id";
    $query->condition->first_name = '%'.$user_name.'%';
    $query->condition->last_name = '~%'.$user_name.'%';
    $result = $query->execute();

    return array_column($result, 'user_id');
}
