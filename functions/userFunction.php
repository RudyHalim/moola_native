<?php
function getUserIdByLogin($email, $password) {
	global $mysqli;

	$sql="SELECT user_id FROM users WHERE email_addr = '".$email."' AND passwd = MD5('".$password."') AND is_active = 'Y' ";
	
	if($result = $mysqli->query($sql)) {
		$obj = $result->fetch_object();
		if(isset($obj->user_id))
			return $obj->user_id;
	}
	
	return 0;
}

function checkLogin1($email, $password) {
	global $mysqli;

	$sql="SELECT user_id FROM users WHERE email_addr = '".$email."' AND passwd = MD5('".$password."') ";
	
	if($result = $mysqli->query($sql)) {
		while ($obj = $result->fetch_object()) {
			echo $obj->user_id;
		}
	}
	return false;
}
?>