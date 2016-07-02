<?php
function getRoleNameById($role_id) {
	$query = new Query;
	$query->select = 'roles';
	$query->condition->role_id = $role_id;
	$query->limit= 1;
	
	$result = $query->execute();
	return $result[0]['role_name'];
}

function generateCbRole($selected="") {

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

function getListRoleIdSearchByName($role_name) {
    $query = new Query;
    $query->select = "roles";
    $query->fields = "role_id";
    $query->condition->role_name = '%'.$role_name.'%';
    $result = $query->execute();

    return array_column($result, 'role_id');
}
