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
