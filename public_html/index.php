<?php
require_once('../app/login_check.php');

?>
<!-- page not protected by a login -->
<html>
    <head>
        <title>Homepage</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/index.css">

        <?php if ($current_user['loggedin'] == false) { ?>
            <p class="loginoutText"><a href="login.php">Log in</a><a href="register.php">Register</a> </p>
        <?php } else { ?>
            <p class="loginoutText"><a href="edit_links.php">Edit</a><a href="logout.php">Log out</a></p>
        <?php } ?>
    </head>
    <body>
        <!-- Output links
            1) Anonymous, check for arguments (links = dh382 style = hf893./Serve generic
            2) Logged in, get from database -->
        <?php if ($current_user['loggedin'] == false) {
           echo "Not logged in, fam!";


        } else {

            require_once('output_loggedin_links.php');
        } ?>

    </body>
</html>
