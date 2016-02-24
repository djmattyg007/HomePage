<?php
#echo phpinfo();
#die();
$login_required = true;
require_once('login_check.php');

function post($key) {
    if (isset($_POST[$key]))
        return $_POST[$key];
    return false;
}

require_once('dbconn_mysql.php');

// SAVES LINK DATA
// RETURNS:
// 1 =          SQL SAVED SUCCESSFULLY (From an SQL standpoint)
// 2 =          NO POST DATA WAS PROVIDED
// NOTHING =    SQL FAILED
//

// check if we can get hold of the form field
if (!post('styleData')){
    echo "2";
    die();
}

// let make sure we escape the data
$val = mysqli_real_escape_string($mysqli, post('linkData'));

$setdata = $mysqli->query("UPDATE users SET linkdata = '$val' WHERE user_id = $current_user_id");
echo $setdata;
