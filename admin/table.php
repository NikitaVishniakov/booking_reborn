<?php 
    $date = date("Y-m-d");
    $period = 7;
    
//exact date
if(isset($_GET['submit_period'])) {
    $date = $_GET['date'];
    $period = $_GET['period'];
}

?>