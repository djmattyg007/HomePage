<?php
$login_required = true;
require_once('login_check.php');

function tz_list() {
  $zones_array = array();
  $timestamp = time();
  foreach(timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
    $zones_array[$key]['zone'] = $zone;
    $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
  }
  return $zones_array;
}

?>
<!-- page protected by a login -->
<html>
<head>
    <title>Edit Links</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/edit_links.css">
    <link rel="stylesheet" type="text/css" href="lib/toastr.min.css">
    
    <script src="lib/jquery-2.2.0.min.js"></script>
    <script src="lib/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js" type="text/javascript" charset="utf-8"></script>
    
    <script src="js/edit_links.js"></script>  
</head>
<body>
    <p class="loginoutText">
        <a href="index.php">Home</a>
        <a href="logout.php">Log out</a>
    </p>
    <h1 class="top_header">Edit Links!</h1>
    <form id="linkForm" name="linkForm" method="post">
    <p>
        <h2 class="section_header">Links</h2>
        <table class="link_table">
            <tr>
                <th>Group Label</th>
                <th>Link labels</th>
                <th colspan="2">Link data</th>
            </tr>
            <tr>
                <td>
                    <select size="10" name="groupSelect" id="groupSelect"></select>
                </td>
                <td>
                    <select size="10" name="linkSelect" id="linkSelect"></select>
                </td>
                <td>
                    <input type="text" placeholder="Label" name="labelText" id="labelText" disabled="disabled"></input><br/><br/>
                    <input type="text" placeholder="URL" name="urlText" id="urlText" disabled="disabled"></input>
                </td>
                
            </tr>
            <tr>
                <th>
                    <button id="btnMoveGroupUp">&uarr;</button>
                    <button id="btnAddGroup">+</button>
                    <button id="btnRemoveGroup">-</button>
                    <button id="btnMoveGroupDown">&darr;</button>
                </th>
                <th>
                    <button id="btnMoveLinkUp">&uarr;</button>
                    <button id="btnAddLink">+</button>
                    <button id="btnRemoveLink">-</button>
                    <button id="btnMoveLinkDown">&darr;</button>
                </th>
                <th colspan="2"></th>
            </tr>
        </table>
    </p>
    
    
    <p>
        <h2 class="section_header">Style</h2>
        <div id="editor" name="styleData"></div>
        <!--<textarea class="txtStyleText" name="styleData" id="txtStyleText"></textarea>-->
    </p>
    
    <p style="content-align:center;">
        <h2 class="section_header">Greeting text</h2>
        
        <table class="greeting_text_table">
            <tr>
                <td colspan="2">
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="chk_timed_greeting" checked>
                        <label class="onoffswitch-label" for="chk_timed_greeting">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>General Greeting</td>
                <td><input type="text" placeholder="General" name="txtGeneralGreeting" id="txtGeneralGreeting" class="txtGreetingTextBox"></input></td>
            </tr>
            <tr>
                <td>Morning Greeting</td>
                <td><input type="text" placeholder="Morning" name="txtMorningGreeting" id="txtMorningGreeting" class="txtGreetingTextBox"></input></td>
            </tr>
            <tr>
                <td>Afternoon Greeting</td>
                <td><input type="text" placeholder="Afternoon" name="txtAfternoonGreeting" id="txtAfternoonGreeting" class="txtGreetingTextBox"></input></td>
            </tr>
            <tr>
                <td>Evening Greeting</td>
                <td><input type="text" placeholder="Evening" name="txtEveningGreeting" id="txtEveningGreeting" class="txtGreetingTextBox"></input></td>
            </tr>
            <tr>
                <td>Night Greeting</td>
                <td><input type="text" placeholder="Night" name="txtNightGreeting" id="txtNightGreeting" class="txtGreetingTextBox"></input></td>
            </tr>
            <tr>
                <td>Timezone</td>
                <td>
                    <select class='txtGreetingTextBox' id="selectTimeZone" name="selectTimeZone">
                        <option value="0">Timezone</option>
                        <?php foreach(tz_list() as $t) { ?>
                        <option value="<?php print $t['zone'] ?>">
                            <?php print $t['diff_from_GMT'] . ' - ' . $t['zone'] ?>
                        </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            
        </table>
        
        
    </p>
    
    <p class="save_button_p">
        <input type="hidden" name="linkData" id="linkData" value=""/>
        <input type="hidden" name="styleData" id="styleData" value=""/>
        <button href="#" id="btnSave">Save</button>
    </p>
    </form>
    
</body>
</html>
