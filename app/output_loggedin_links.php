<?php

$login_required = true;
require_once('login_check.php');
require_once('dbconn_mysql.php');

$getdata = $mysqli->query("SELECT linkdata, styledata FROM users WHERE user_id = $current_user_id");
$link_json = $getdata->fetch_assoc();
$settings = json_decode($link_json['linkdata'], true);

//OUTPUT STYLE
echo "<style>";
echo $link_json['styledata'];
echo "</style>";


//OUTPUT GREETING
echo "<h1 class=\"greeting_text\">";
if ( $settings['settings']['greetings']['is_time_greeting_on'] ){
    date_default_timezone_set($settings['settings']['timezone']);
    $current_hour= date('H') ;
    
    #Night: 0:00 - 06:00 
    #Morning: 06:00 - 12:00 
    #Afternoon: 12:00 - 18:00 
    #Evening: 18:00 - 0:00/24:00 
    
    if($current_hour >= 0 && $current_hour <= 5){
        echo $settings['settings']['greetings']['night'];
    }
    else if($current_hour >= 6 && $current_hour <= 11){
        echo $settings['settings']['greetings']['morning'];
    }
    else if($current_hour >= 12 && $current_hour <= 17){
        echo $settings['settings']['greetings']['afternoon'];
    }
    else if($current_hour >= 18 && $current_hour <= 24){
        echo $settings['settings']['greetings']['evening'];
    }   
}
else {
    echo $settings['settings']['greetings']['greeting'];
}
echo "</h1>";

echo '<div class="group_container" >';
//OUTPUT LINKS
foreach( $settings['link_settings'] as $group_key => $group_value){
    $group_name = $group_value["group_label"];
    echo"
        <div class=\"group_div\">
        <div class=\"group_label\">$group_name</div>
        <ul class=\"link_list\">
    ";
    foreach( $group_value["links"] as $link_key => $link_value){
        $our_label = $link_value["link_label"];
        $our_url = $link_value["link_label"];
        echo"
            <li class=\"link_item\">
                <a class=\"link\" href=\"$our_url\" target=\"_blank\">$our_label</a>
            </li>
        ";
      echo "";
    }
    echo "</ul></div>";
}

echo "</div>";
