<?php

// make a new goddamn user

if (!isset($_POST['e']) || trim($_POST['e']) == '') {
	die('you forgot to put in a goddamn email address, jeez.');
}

if (!filter_var(trim($_POST['e']), FILTER_VALIDATE_EMAIL)) {
	die('the email address you put in is invalid, jeez.');
}

if (!isset($_POST['p1']) || trim($_POST['p1']) == '') {
	die('you forgot to put in your password, jeez.');
}

if (!isset($_POST['p2']) || trim($_POST['p2']) == '') {
	die('you forgot to put in your password again, jeez.');
}

if (trim($_POST['p1']) != trim($_POST['p2'])) {
	die('your passwords do not match, goddamn.');
}

require_once('dbconn_mysql.php');

// ok, make a new user
$new_user_email_db = "'".$mysqli->escape_string(trim($_POST['e']))."'";

// check to see if email already in use
$check_for_email = $mysqli->query("SELECT user_id FROM users WHERE email=$new_user_email_db");
if ($check_for_email->num_rows > 0) {
	die('sorry, but that email address appears to already be in use.');
}

$new_user_pwd_hash_db = password_hash($_POST['p1'], PASSWORD_BCRYPT);

$default_links = fopen("defaultlinks.json", "r") or die("Unable to open file!");
$default_links_data = mysqli_real_escape_string($mysqli, fread($default_links ,filesize("defaultlinks.json")));
fclose($default_links );

$new_user_row = $mysqli->query("INSERT INTO users (email, pwrdlol, tsc, linkdata)VALUES ($new_user_email_db, '$new_user_pwd_hash_db', UNIX_TIMESTAMP(), '$default_links_data')");

if (!$new_user_row) {
	die('error creating new user: '.$mysqli->error);
}

$new_user_id = $mysqli->insert_id;

header('Location: login.php?register_success');
