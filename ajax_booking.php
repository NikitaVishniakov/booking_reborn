<?php 
include("connection.php");
include("funcs.php");
if(isset($_GET['type'])){
//    ajax for price
    if($_GET['type'] == "price"){
        $dateStart = $_GET['dateStart'];
        $dateEnd = $_GET['dateEnd'];
        $roomNum = $_GET['roomNum'];
        $discount = intval($_GET['discount'])/100;
        $roomType = getRoomType($roomNum);
        $guestsNum = getGuestsNum($_GET['guestsNum'], $roomType)['guestsNum'];
        $extraPlace = getGuestsNum($_GET['guestsNum'], $roomType)['extraPlace'];
        $days = getDaysCount($dateEnd, $dateStart);
        if(!isset($_GET['price'])){
            $sql = "SELECT date, price FROM price WHERE roomType = '{$roomType}' AND places = {$guestsNum} AND extraPlace = {$extraPlace} ORDER BY date ASC"; 
//            echo $sql;
            $period = allDatesInperiod($dateStart, $dateEnd);
            $prices = array();
            foreach($period as $int){
                $price = getPrice($int, $sql);
                $prices[$int] = $price;
            }
            $total = array_sum($prices);
            $price = array_unique($prices);
              
        $total = $total -$total * $discount;
        }
        else {
            $price = $_GET['price'];
            $total = intval($days) * $price;
        }
//      
        if(isset($_GET['price_night'])){
            foreach($price as $val){
                echo $val." ";
            }
        }
        else{
            echo $total;
        }
    }
    if($_GET['type'] == "guestsNum"){
        selectGuestNum($_GET['roomNum']);
    }
    if($_GET['type'] == "checkIsFree"){
        $arr = isRoomFree($_GET['roomNum'], $_GET['dateStart'], $_GET['dateEnd']);
//        $arr =["check" => "booka"];
        echo $arr;
    }
}


?>