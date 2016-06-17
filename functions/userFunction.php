<?php
function getUserIdByLogin($email, $password) {
    global $mysqli;

    $sql="SELECT user_id FROM users WHERE email_addr = '".$email."' AND passwd = MD5('".$password."') AND is_active = 'Y' LIMIT 1";

    if($result = $mysqli->query($sql)) {
        $obj = $result->fetch_object();
        if(isset($obj->user_id))
            return $obj->user_id;
    }

    return 0;
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
