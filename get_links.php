<?php
$login_required = true;
require_once('login_check.php');
require_once('dbconn_mysql.php');

$getdata = $mysqli->query("SELECT linkdata FROM users WHERE user_id = $current_user_id");

$link_data = $getdata->fetch_assoc();
echo $link_data['linkdata'];