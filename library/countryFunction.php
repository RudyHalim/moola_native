<?php
function getCountryNameById($country_id) {
	$query = new Query;
	$query->select = 'countries';
	$query->condition->country_id = $country_id;
	$query->limit= 1;
	
	$result = $query->execute();
	return $result[0]['country_name'];
}

function generateCbCountries($selected="") {

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

function getListCountryIdSearchByName($country_name) {
    $query = new Query;
    $query->select = "countries";
    $query->fields = "country_id";
    $query->condition->country_name = '%'.$country_name.'%';
    $result = $query->execute();

    return array_column($result, 'country_id');
}

function generateCbCurrency($selected="") {

    $array = array();
    $query = new Query;
    $query->select = "countries";
    $query->condition->country_trade = "Y";
    $query->orderby = "country_name";

    $data = $query->execute();

    foreach ($data as $key => $value) {
        $array[$value['country_id']] = $value['country_name']." - ".$value['country_currency'];   
    }

    return generateSelectOptions($array, $selected);
}

function getCurrencyNameById($country_id) {
    $query = new Query;
    $query->select = 'countries';
    $query->field = 'country_currency';
    $query->condition->country_id = $country_id;
    $query->limit= 1;
    
    $result = $query->execute();
    return $result[0]['country_currency'];
}

function getListCurrencyIdSearchByName($currency_name) {
    $query = new Query;
    $query->select = "countries";
    $query->fields = "country_id";
    $query->condition->country_name = '%'.$currency_name.'%';
    $query->condition->country_currency = '~%'.$currency_name.'%';
    $result = $query->execute();

    return array_column($result, 'country_id');
}