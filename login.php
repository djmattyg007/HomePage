<?php

// login page if they are not already logged in

require_once('login_check.php');

if (isset($current_user) && isset($current_user['loggedin']) && $current_user['loggedin'] == true) {
	header('Location: index.php');
	die();
}

?>
<html>
<head>
    <title>login</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body id="login" onload="document.getElementById('start-here').focus()">
    <div id="login-prompt" class="login-prompt">
        <h1>login</h1>
        <?php
        if (isset($_GET['register_success'])) {
            ?>
            <p><span class="registered">Registration successful.</span></p>
            <?php
        }
        ?>
        <form action="login.php" method="post">
            <p><input tabindex="1" id="start-here" name="e" type="email" placeholder="you@butt.com" /></p>
            <p><input tabindex="2" name="p" type="password" /></p>
            <p><input tabindex="3" type="submit" value="log in &raquo;" /></p>
        </form>
        <p><a href="register.php">Register</a></p>  
    </div>

</body>
</html>