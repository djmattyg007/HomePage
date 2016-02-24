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
// 3 =          linkData was empty. Protecting accidental data deletion
// 4 =          styleData was empty. Protecting accidental data deletion
// 5 =          Final data to be committed link or style data was null!
// NOTHING =    SQL FAILED
//

// check if we can get hold of the form field
if (!post('linkData')){
    echo "2";
    die();
}

if (!post('styleData')){
    echo "3";
    die();
}

// let make sure we escape the data
$linkVal = mysqli_real_escape_string($mysqli, post('linkData'));
$styleVal = mysqli_real_escape_string($mysqli, post('styleData'));

if ( $linkVal == "" || $styleVal == ""){
    echo "4";
    die();
}

$setdata = $mysqli->query("UPDATE users SET linkdata = '$linkVal', styledata = '$styleVal' WHERE user_id = $current_user_id");
echo $setdata;
