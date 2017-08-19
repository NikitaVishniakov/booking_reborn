<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 11.07.17
 * Time: 18:57
 */
$sources = ["Booking", "Ostrovok", "Постоянщик", "С улицы", "Другое"];
$categories = [1=>'Стандарт', 2=>'Улучшенный'];
$rooms = [1=>[1=>'1',3=> '3'],2=>[2=>'2',4=>'4',5=>'5']];
$months =['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентрябрь','Октябрь','Ноябрь','Декабрь'];
$periods = array(7=>'Неделя',14=>'Две недели',31=>'Месяц');
$payments = ['Оплата при заселении', 'Предавторизация платежа'];
$plus_payments = ['Проживание', 'Доп. услуги', 'Предоплата'];
$minus_payments = ['Возврат', 'Инкассация', 'Закупки', 'Прачечная'];
$guestsNum = array(1=>['1','2'], 2=>['1', '2', '2+1'], 3=>['1', '2'], 4=>['1', '2','2+1'], 5=>['1','2']);
function selectGuestNum($roomNum, $chosen = '1'){
    global $guestsNum;
    foreach($guestsNum[$roomNum] as $guests){
        if($chosen == $guests){
            $selected = "selected";
        }
        else {
            $selected = "";
        }
        echo "<option {$selected} value='{$guests}'>{$guests}</option>";
    }
}
function selectRoom ($category, $chosen = 1){
    global $rooms;
    global $categories;
    foreach($rooms[$category] as $key => $room){
        if($chosen == $key){
            $selected = "selected";
        }
        else {
            $selected = "";
        };
        echo "<option $selected value='{$key}'>{$categories[$category]} № $room </option>";
    }
}
function getDaysCount($from, $to){
    $from = date_create($from);
    $to = date_create($to);
    return date_diff($from, $to)->format('%a');
}

function allDatesInPeriod($from, $to, $add=0){
    $from = new DateTime($from);
    $to = new DateTime($to);
    $to->modify("+{$add} day");
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($from, $interval ,$to);
    $array_period = [];
    foreach($period as $date) {
        array_push($array_period, $date->format("Y-m-d"));
    }
    return $array_period;
}

function changeDate($date, $value, $symbol = '+', $unit = 'days'){
    return date_format(date_modify(date_create($date), "$symbol $value $unit"),"d.m.Y");
}
if($_GET['type'] == "rooms"){
    selectRoom($_GET['category']);
}
if($_GET['type'] == "guestsNum"){
    selectGuestNum($_GET['roomNum']);
}
if($_GET['type'] == 'total_price'){
    $dateStart = strlen($_GET['dateStart']) ? $_GET['dateStart'] : date('d.m.Y');
    $dateEnd = strlen($_GET['dateEnd']) ? $_GET['dateEnd'] : date_format(date_modify(date_create(), '+1 day'),"d.m.Y");
    $days = getDaysCount($dateEnd, $dateStart);
    $price = $_GET['total'] / $days;
    echo $price;
}
if($_GET['type'] == "night_price") {
    $dateStart = strlen($_GET['dateStart']) ? $_GET['dateStart'] : date('d.m.Y');
    $dateEnd = strlen($_GET['dateEnd']) ? $_GET['dateEnd'] : date_format(date_modify(date_create(), '+1 day'), "d.m.Y");
    $price = $_GET['price'];
//    $roomNum = $_GET['roomNum'];
//    $discount = intval($_GET['discount'])/100;
//    $roomType = getRoomType($roomNum);
//    $guestsNum = getGuestsNum($_GET['guestsNum'], $roomType)['guestsNum'];
//    $extraPlace = getGuestsNum($_GET['guestsNum'], $roomType)['extraPlace'];
    $days = getDaysCount($dateEnd, $dateStart);
    $total = $price * $days;
    echo $total;
}
if($_GET['type'] == 'count_price'){
    $dateStart = (isset($_GET['dateStart']) && strlen($_GET['dateStart'])) ? $_GET['dateStart'] : date('d.m.Y');
    $dateEnd = (isset($_GET['dateEnd']) && strlen($_GET['dateEnd'])) ? $_GET['dateEnd'] : changeDate($dateStart, 1);
    $roomCat = (isset($_GET['roomCat']) && strlen($_GET['roomCat'])) ? $_GET['roomCat'] : 1;
    $guestsNum = (isset($_GET['guestsNum']) && strlen($_GET['guestsNum'])) ? $_GET['guestsNum'] : 1;
    $breakfast = (isset($_GET['breakfast']) && strlen($_GET['breakfast'])) ? $_GET['breakfast'] : 0;
    $specialGuest = (isset($_GET['specialGuest']) && strlen($_GET['specialGuest'])) ? $_GET['specialGuest'] : 0;
    $discount = (isset($_GET['discount']) && strlen($_GET['discount'])) ? $_GET['discount'] : 0;
    $days = getDaysCount($dateEnd, $dateStart);
    if($roomCat == 1){
        if ($guestsNum == 1){
            $price = 2000;
        }
        else{
            $price = 2500;
        }
    }
    else{
        if ($guestsNum == 1){
            $price = 3000;
        }
        else{
            $price = 3500;
        }
    }
    if($breakfast){
        $price +=150;
    }
    if($specialGuest){
        $price *= 0.9;
    }
    if($discount){
        $price = $price - $price * $discount/100;
    }
    $total = $price * $days;
    header('Content-Type: application/json');
    $arr = array('total' => $total, 'price' => $price);
    echo json_encode($arr);
}