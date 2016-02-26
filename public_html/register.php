<html>
<head>
        <title>Register</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body id="register" onload="document.getElementById('start-here').focus()">
    <div id="register-prompt" class="login-prompt">
        <h1>register</h1>
        <form action="register_process.php" method="post">
            <p><label>Your Email:</label> <input tabindex="1" id="start-here" name="e" type="email" placeholder="you@fuck.off" /></p>
            <p><label>Your Password:</label> <input tabindex="2" name="p1" type="password" /></p>
            <p><label>Your Password:</label> <input tabindex="3" name="p2" type="password" /></p>
            <p><input tabindex="5" type="submit" value="sign up &raquo;" /></p>
        </form>
        <p><a href="index.php">Home</p>
    </div>
    </body>
</html>