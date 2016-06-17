<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moola Native</title>
    <link href="#" rel="icon">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <link href="/css/ui.css" type="text/css" rel="stylesheet">
</head>
<body>
<div id="notif">
    <?php
        if(isset($_SESSION['flash_msg'])) {
            echo '<p>'.$_SESSION['flash_msg'].'</p>';
            unset($_SESSION['flash_msg']);
        }
    ?>
</div>
