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

function generateSelectOptions($array, $selected) {
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

function generateCbCountries($selected) {

    $array = array();
    $query = new Query;
    $query->select = "countries";
    $query->orderby = "country_name";

    $data = $query->execute();

    foreach ($data as $key => $value) {
        $array[$value['country_id']] = $value['country_name'];   
    }

    return generateSelectOptions($array, $selected);
}

function generateCbRole($selected) {

    $array = array();
    $query = new Query;
    $query->select = "roles";
    $query->orderby = "role_id";

    $data = $query->execute();

    foreach ($data as $key => $value) {
        $array[$value['role_id']] = $value['role_name'];   
    }

    return generateSelectOptions($array, $selected);
}
