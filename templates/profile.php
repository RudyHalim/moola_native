<?php
include($config['application']['includesDir']."menus.php");

?><h1>Profile</h1><?php

$userData = getUserDataByUserId($_SESSION['user_id']);
include($config['application']['includesDir']."profileform.php");
?>