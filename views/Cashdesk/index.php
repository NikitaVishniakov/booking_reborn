<?php
$dates = [];
$days_option = [3,10,15,30];
if(isset($_GET['days'])){
    $days = $_GET['days'];
}
else {
    $days = 3;
}
for($i = $days - 1; $i >= 0; $i--){
    $day = new DayBalance($i);
    array_push($dates, $day);
}
$dates = array_reverse($dates);
$permission = permissionControl();

global $query;
$refresh = $query;
if(!isset($_GET['refresh'])) {
    if (count($_GET) > 1) {
        $symbol = '&';
    } else {
        $symbol = '?';
    }
    $refresh .= $symbol . "refresh=Y";
}


require_once TEMPLATES . "/cashdesk.php";
