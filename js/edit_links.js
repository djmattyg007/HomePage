child_template =  {
    "group_label": "New Group",
    "links": [
        {
            "link_label": "Sample Link",
            "link_url": "Google.com"
        }
    ]
};

link_template = {
    "link_label": "Sample Link",
    "link_url": "Google.com"
};
var editor;

$( document ).ready(function() {

    //Initializaition//
    editor = ace.edit("editor");
    //https://github.com/ajaxorg/ace/tree/master/lib/ace/theme
    //Setting to change theme?
    editor.setTheme("ace/theme/dawn");
    editor.getSession().setMode("ace/mode/css");
    editor.getSession().setTabSize(4);
    editor.setValue("new code here!");;
    
    getGroups();
    getStyle();
    
    //Events//
    $( "#btnAddGroup" ).click(function() {
        insertNewGroup();
        updateLinkList();
    });
    
    $( "#btnRemoveGroup" ).click(function() {
        removeGroup();
        updateLinkList();
    });
    
    $( "#btnMoveGroupUp" ).click(function() {
        moveGroupUp();
        updateLinkList();
    });
    
     $( "#btnMoveGroupDown" ).click(function() {
        moveGroupDown();
        updateLinkList();
    });
    
    
     $( "#btnAddLink" ).click(function() {
        insertNewLink();
    });
    
    $( "#btnRemoveLink" ).click(function() {
        removeLink();
    });
    
    $( "#btnMoveLinkUp" ).click(function() {
        moveLinkUp();
    });
    
     $( "#btnMoveLinkDown" ).click(function() {
        moveLinkDown();
    });
    
    $('#btnSave').on('click', function(e){
       saveDataEvent(e);
    });

    $("#chk_timed_greeting").change( function(){
        changeGreetingType($(this).is(':checked'));
    });
    
    
    $('#labelText').on('input', function() {
        updateLinkData();
    });
    
    $('#urlText').on('input', function() {
        updateLinkData();
    });
    
    $( "#selectTimeZone" ).change(function() {
        data.settings.timezone = $( "#selectTimeZone" ).val();
        console.log(data.settings.timezone);
    });//End groupSelect change
    
    $( "#groupSelect" ).change(function() {
        updateLinkList();
        $("#labelText").attr("disabled", "disabled"); 
        $("#urlText").attr("disabled", "disabled"); 
    });//End groupSelect change
    
    $( "#linkSelect" ).change(function() {
        updateLinkBoxes();
    });//End linkSelect change
    
    $('#txtGeneralGreeting').on('input', function() {
        console.log("general");
        data.settings.greetings.greeting = $('#txtGeneralGreeting').val();
    });
    
    $('#txtMorningGreeting').on('input', function() {
        data.settings.greetings.morning = $('#txtMorningGreeting').val();
    });
    
    $('#txtAfternoonGreeting').on('input', function() {
        data.settings.greetings.afternoon = $('#txtAfternoonGreeting').val();
    });
    
    $('#txtEveningGreeting').on('input', function() {
        data.settings.greetings.evening = $('#txtEveningGreeting').val();
    });
    
    $('#txtNightGreeting').on('input', function() {
        data.settings.greetings.night = $('#txtNightGreeting').val();
    });
    
    $(window).bind('keydown', function(event) {
        if ((event.ctrlKey || event.metaKey) && String.fromCharCode(event.which).toLowerCase() == 's') {
            event.preventDefault();
            saveData();
        }
    });

    
});

//View updating logic
//Group Logic
function insertNewGroup(){
    var currentIndex = $('#groupSelect')[0].selectedIndex;
    if (currentIndex == -1){
        data.link_settings.push(child_template);
    }
    else{
        data.link_settings.splice(currentIndex + 1, 0, child_template);
        data.link_settings.join();
    }
    
    updateGroupList();
    
    if (currentIndex === -1){
        $('#groupSelect')[0].selectedIndex = $('#groupSelect')[0].length - 1;
    }
    else{
        $('#groupSelect')[0].selectedIndex = currentIndex + 1;
    }
}

function removeGroup(){
    var currentIndex = $('#groupSelect')[0].selectedIndex;
    
    if (currentIndex === -1){
        return;
    }
    else{
        data.link_settings.splice(currentIndex,1);
    }
    
    updateGroupList();
    
    if ($('#groupSelect')[0].length > 0){
        $('#groupSelect')[0].selectedIndex = currentIndex;
    }
}

function moveGroupUp(){
    var selectedIndex = $('#groupSelect')[0].selectedIndex;
    
    if (selectedIndex > 0){
        swapArrayElements(data.link_settings, selectedIndex, selectedIndex - 1);
        $('#groupSelect')[0].selectedIndex = selectedIndex - 1
        updateGroupList();
        updateLinkList();
    }
}

function moveGroupDown(){
    var selectedIndex = $('#groupSelect')[0].selectedIndex;
    
    if (selectedIndex < $('#groupSelect')[0].length - 1){
        swapArrayElements(data.link_settings, selectedIndex, selectedIndex + 1);
        $('#groupSelect')[0].selectedIndex = selectedIndex + 1
        updateGroupList();
        updateLinkList();
    }
}


//Link Logic
function insertNewLink(){
    if( $('#groupSelect')[0].selectedIndex  == -1){
        return;
    }
    
    var currentIndex = $('#linkSelect')[0].selectedIndex;
    var links = data.link_settings[$('#groupSelect')[0].selectedIndex].links;
    
    if (currentIndex == -1){
        links.push(link_template);
    }
    else{
        links.splice(currentIndex + 1, 0, link_template);
        links.join();
    }

    updateLinkList();
    
    if (currentIndex == -1){
        $('#linkSelect')[0].selectedIndex = $('#linkSelect')[0].length - 1;
    }
    else{
        $('#linkSelect')[0].selectedIndex = currentIndex + 1;
    }
    updateLinkBoxes();
}

function removeLink(){
    //If no link is selected, return
    if( $('#groupSelect')[0].selectedIndex == -1 ){
        return;
    }
    
    var currentIndex = $('#linkSelect')[0].selectedIndex;
    var links = data.link_settings[$('#groupSelect')[0].selectedIndex].links;
    

    links.splice(currentIndex,1);
    
    updateLinkList();
    
    //Do we have any links left to select?
    if ($('#linkSelect')[0].length > 0){
        //Did we delete the link at the end? If so, select the new last link
        if( $('#linkSelect')[0].length == currentIndex){
            $('#linkSelect')[0].selectedIndex = currentIndex - 1;
        }
        else{
            $('#linkSelect')[0].selectedIndex = currentIndex;
        }
    }
    updateLinkBoxes();
    
    if ( $('#linkSelect')[0].length == 0){
        $("#labelText").attr("disabled", "disabled"); 
        $("#urlText").attr("disabled", "disabled"); 
    }
}

function moveLinkUp(){
    if( $('#groupSelect')[0].selectedIndex == -1 || $('#linkSelect')[0].selectedIndex == -1){
        return;
    }
    
    var selectedIndex = $('#linkSelect')[0].selectedIndex;
    var links = data.link_settings[$('#groupSelect')[0].selectedIndex].links;
    
    if (selectedIndex > 0){
        swapArrayElements(links, selectedIndex, selectedIndex - 1);
        updateLinkList();
        $('#linkSelect')[0].selectedIndex = selectedIndex - 1
        updateLinkBoxes();
    }
}

function moveLinkDown(){
    if( $('#groupSelect')[0].selectedIndex == -1 || $('#linkSelect')[0].selectedIndex == -1 ){
        return;
    }
    
    var selectedIndex = $('#linkSelect')[0].selectedIndex;
    var links = data.link_settings[$('#groupSelect')[0].selectedIndex].links;
    
    if (selectedIndex < $('#linkSelect')[0].length - 1){
        swapArrayElements(links, selectedIndex, selectedIndex + 1);
        updateLinkList();
        $('#linkSelect')[0].selectedIndex = selectedIndex + 1
        updateLinkBoxes();
    }
}



//UI Update Logic//
function updateGroupList(){
    var selectedIndex = $('#groupSelect')[0].selectedIndex;
    
    $('#groupSelect')
        .find('option')
        .remove()
        .end()
    ;
    
    $.each(data.link_settings, function(i, item) {
        $('#groupSelect').append($('<option>', {
            value: item.group_id,
            text: item.group_label
        }));
    })
    
    $('#linkSelect')
        .find('option')
        .remove()
        .end()
    ;
    
    $('#groupSelect')[0].selectedIndex = selectedIndex;
}

function updateLinkList(){
    var link_index = $('#linkSelect')[0].selectedIndex;
    
    $('#linkSelect')
        .find('option')
        .remove()
        .end()
    ;
    $( "#labelText" ).val("");
    $( "#urlText" ).val("");
    
    $.each(data.link_settings[$('#groupSelect')[0].selectedIndex].links, function(i, link) {
            $('#linkSelect').append($('<option>', {
                value: link.link_label,
                text: link.link_label
            }));
    });

}

function updateLinkBoxes(){
    //Protect against an empty link list
    if( $('#linkSelect')[0].length == 0){
        $("#labelText").attr("disabled", "disabled"); 
        $("#urlText").attr("disabled", "disabled"); 
    }
    //Protect against no selected link
    else if($('#linkSelect')[0].selectedIndex == -1){
        $("#labelText").attr("disabled", "disabled"); 
        $("#urlText").attr("disabled", "disabled"); 
    }
    else{
        $("#labelText").removeAttr("disabled"); 
        $("#urlText").removeAttr("disabled"); 
        
        $( "#labelText" ).val("") 
        $( "#urlText" ).val("")
        our_group = data.link_settings[$('#groupSelect')[0].selectedIndex];
        //Try to find the group we want by group_id
        $( "#labelText" ).val(our_group.links[$('#linkSelect')[0].selectedIndex].link_label) 
        $( "#urlText" ).val(our_group.links[$('#linkSelect')[0].selectedIndex].link_url)  
    }
}

function updateLinkData(){
    var groupIndex = $('#groupSelect')[0].selectedIndex;
    var labelIndex = $('#linkSelect')[0].selectedIndex;
    
    if( groupIndex == -1 || labelIndex == -1 ){
            return;
    }
    
    var our_group = data.link_settings[$('#groupSelect')[0].selectedIndex];
    var our_links = our_group.links[$('#linkSelect')[0].selectedIndex];
    
    our_links.link_label = $('#labelText').val();
    our_links.link_url = $('#urlText').val();
    
    $('#linkSelect')[0].options[labelIndex].text = our_links.link_label;
}

//Logic Helpers//
function swapArrayElements(arr, indexA, indexB) {
    var temp = arr[indexA];
    arr[indexA] = arr[indexB];
    arr[indexB] = temp;
};

function saveDataEvent(e){
    e.preventDefault();
    saveData();
}

function saveData(){
    document.linkForm.linkData.value = JSON.stringify(data);
    document.linkForm.styleData.value = editor.getValue();
    
    $.ajax({
      type: 'post',
      url: 'save_links.php',
      data: $('#linkForm').serialize(),
      success: function(results) {
        if ( results == "1" ){
            toastr.info('Save Successful!')
            console.log(results);
        }
        else if( results == "2" ){
            toastr.info('Tell the Developer that no linkData POST was sent for you :(. Save Cancelled')
        }
        else if( results == "3" ){
            toastr.info('Tell the Developer that no styleData POST was sent for you :(. Save Cancelled')
        }
        else if( results == "4" ){
            toastr.info('Tell the Developer that final data converson resulted in an empty value. Save Cancelled')
        }
        
        else{
            var output = 'For some reason, this error happend:' + results;
            toastr.info( output )
        }
      }
    });
}

function saveDataDebug(){
    document.linkForm.linkData.value = JSON.stringify(data);
    document.forms["linkForm"].submit();
}

function getGroups(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var ass = xmlhttp.responseText;
            data = jQuery.parseJSON( xmlhttp.responseText );
            updateGroupList();
            getGreeting();
        }
    };
    xmlhttp.open("GET", "get_links.php", true);
    xmlhttp.send();
}

function getStyle(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            editor.setValue(xmlhttp.responseText);
            editor.gotoLine(0);
        }
    };
    xmlhttp.open("GET", "get_style.php", true);
    xmlhttp.send();
}

function getGreeting(){
    //console.log(data.settings.greetings.greeting);
    
    $("#txtGeneralGreeting").val(data.settings.greetings.greeting);
    $("#txtMorningGreeting").val(data.settings.greetings.morning);
    $("#txtAfternoonGreeting").val(data.settings.greetings.afternoon);
    $("#txtEveningGreeting").val(data.settings.greetings.evening);
    $("#txtNightGreeting").val(data.settings.greetings.night);
    
    $('#chk_timed_greeting').prop('checked', data.settings.greetings.is_time_greeting_on);
    changeGreetingType(data.settings.greetings.is_time_greeting_on)
    
    $("#selectTimeZone").val(data.settings.timezone);
}

function changeGreetingType(is_time_based){
    //True = Time
    //False = General
    data.settings.greetings.is_time_greeting_on = is_time_based;
    
    if (is_time_based){
        $("#txtGeneralGreeting").attr("disabled", "disabled");
        $("#txtMorningGreeting").removeAttr("disabled");
        $("#txtAfternoonGreeting").removeAttr("disabled");
        $("#txtEveningGreeting").removeAttr("disabled");
        $("#txtNightGreeting").removeAttr("disabled");
        $("#selectTimeZone").removeAttr("disabled");
    }
    else{
        $("#txtGeneralGreeting").removeAttr("disabled");
        $("#txtMorningGreeting").attr("disabled", "disabled");
        $("#txtAfternoonGreeting").attr("disabled", "disabled");
        $("#txtEveningGreeting").attr("disabled", "disabled");
        $("#txtNightGreeting").attr("disabled", "disabled");
        $("#selectTimeZone").attr("disabled", "disabled");
    }
}


  

