<?php
function breakUrlFormat($url) {
    $exploded = explode("/", ltrim($url, '/'), 3);

    $result['module']       = isset($exploded[0]) ? $exploded[0] : '';
    $result['action']       = isset($exploded[1]) ? $exploded[1] : '';
    $result['parameter']    = isset($exploded[2]) ? $exploded[2] : '';

    return $result;
}
