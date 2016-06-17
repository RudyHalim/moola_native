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
    global $mysqli;

    $sql="SELECT * FROM users WHERE user_id = '".$user_id."' LIMIT 1";

    if($result = $mysqli->query($sql)) {
        $obj = $result->fetch_object();
        return $obj;
    }
    return 0;
}
