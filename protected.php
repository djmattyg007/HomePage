<?php
$login_required = true;
require_once('login_check.php');

?>
<!-- page protected by a login -->
<html>
<head>
    <title>protected page test</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <p class="loginoutText">
        <a href="logout.php">Log out</a>
    </p>
    <p>This page is protected by a login!</p>
    
</body>
</html>