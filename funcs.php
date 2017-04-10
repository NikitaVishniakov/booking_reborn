<?php
//constants
date_default_timezone_set('Europe/Moscow');
if(!isset($_SESSION['id'])){
    session_start();
}
$sources = ["Booking", "Ostrovok", "Постоянщик", "С улицы", "Другое"];
$rooms = ['№1 (Стандарт)', '№2 (Улучшенный)','№3 (Стандарт)','№4 (Улучшенный)','№5 (Улучшенный)'];
$months =['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентрябрь','Октябрь','Ноябрь','Декабрь'];
$periods = array(7=>'Неделя',14=>'Две недели',31=>'Месяц');
$payments = ['Оплата при заселении', 'Предавторизация платежа'];
$plus_payments = ['Проживание', 'Доп. услуги', 'Предоплата'];
$minus_payments = ['Возврат', 'Инкассация', 'Закупки', 'Прачечная'];
$guestsNum = array(1=>['1','2'], 2=>['1', '2', '2+1'], 3=>['1', '2'], 4=>['1', '2','2+1'], 5=>['1','2']);
$pay_types = ['Наличные', 'Безналичный расчет'];
$cleanTheRoom = 3;
function selectPaymentName($plus, $name){
    global $plus_payments;
    global $minus_payments;
    if($plus = '+'){
        foreach($plus_payments as $payment){
            if($name == $payment){
                $select = "selected";
            }
            else{
                $select = "";
            }
            echo "<option $select value='$payment'>$payment</option>";
        }
    }
    else{
        foreach($plus_payments as $payment){
            if($name == $payment){
                $select = "selected";
            }
            else{
                $select = "";
            }
        echo "<option $select value='$payment'>$payment</option>";
        }
    }
}
function selectPaymentType($selected = ""){
    global $pay_types;
    foreach($pay_types as $type){
        if($selected == $type){
            $select = "selected";
        }
        else{
            $select = "";
        }
        echo "<option $select value='$type'>$type</option>";
    }
}
function passHash($password){
    $password = $password."b7g89";
    $password = hash('sha512', $password);
    $password = strrev($password);
    return $password;
}
function inputControl($string) {
    //$string = mysqli_real_escape_string($string);
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
    }
function authCheck(){
    if(!isset($_SESSION['id'])){
        header("location:auth.php");
    }
}
function auth($login, $pass){
        $pass = inputControl(passHash($pass));
        $login = inputControl($login);
                include("connection.php");
                $query = $link->query("SELECT login, status FROM users WHERE login ='".$login."' AND password = '".$pass."'");
//    echo "SELECT login FROM users WHERE login ='".$login."' AND password = '".$pass."'";
                if (mysqli_num_rows($query) > 0) {
                    $query = $query->fetch_array();
                    $_SESSION['id'] = $query['login'];
                    $_SESSION['status'] = $query['status'];
                    unset($_SESSION['error']);
                    $login = $link->query("UPDATE users SET dateSignUp='".date('Y-m-d')."' WHERE login = '".$_SESSION['id']."'");
                    header("location: index.php");
                }
                else {
                    $_SESSION['error'] = "Неверно указан логин или пароль";
                }
}
function numDays($month) {
    if($month < 7) {
        if($month%2 == 0  && $month != 2) {
            $numDays = 30;
        }
        elseif($month == 2) {
            $numDays = 28;
        }
        else {
            $numDays = 31;
        }
    }
    elseif($month == 7) {
        $numDays = 31;
    }
    else {
        if($month%2 == 0) {
            $numDays = 31;
        }
        else {
            $numDays = 30;
        }
    }
    return $numDays;
}
function dataCount($date, $period) {
        $from = date_format(date_create($date),"Y-m-d");
        $to = new DateTime($from);
        $to = $to->modify("+{$period} day");
        $to = strval($to->format("Y-m-d"));
        $dates = allDatesInPeriod($from, $to);
        return $dates;

}

//echo dataCount(1,20,14);
function tableRoom(){
    global $rooms;
    foreach($rooms as $room) {
            echo "<td>{$room}</td>";
    }
}

function tableFill($dates, $booking) {
    global $rooms;
    global $cleanTheRoom;
    foreach($dates as $date) {
        $td_date = date_format(date_create($date), "d.m.Y");
        if($td_date == '19.05.2017'){
            $bg_blue = "bg-blue";
        }
        else{
            $bg_blue = "";
        }
        echo "<tr class='{$bg_blue}'><td>{$td_date}</td>";
        foreach($rooms as $key => $room) {
            $class = 'free';
            $id = $date;
            $status = "";
            $guestName = "";
            $genious = "";
            $breakfast = "";
            $div = "";
            $clean = "";
            $deposit = "";
            foreach($booking as $row){
                if(intval($key)+1 == intval($row['roomNum'])){
                    $date = date_format(date_create($date), "Y-m-d");
                    for($i = 0; $i < count($row['dates']); $i++){
                        if($date == $row['dates'][$i]){
                            if(count($row['dates']) > 5){
                                if($i%intval($cleanTheRoom) == 0){
                                    $clean = "Прибрать номер";
                                }
                            }
                        
                            $id = $row['id'];
                            $class = "booked";
                            if($row['dates'][0] <= date('Y-m-d')){
                                if($row['checkIn']){
                                    if(getDebt($id, $row['amount']) > 0){
                                        $class .= " hasDebt";
                                    }
                                }
                            }
                            if($row['Genious'] == 1){
                                $genious = "genius genious status";
                            }
                            if($row['breakfast'] == 1){
                                $breakfast ="<span class='glyphicon glyphicon-cutlery breakfast status'></span>";
                            }
                            if($row['guestsNum'] == "2"){
                                $breakfast = str_repeat($breakfast, 2);
                            } 
                            if($row['deposit'] == 1){
                                $deposit = "glyphicon glyphicon-piggy-bank deposit";
                            }
                            elseif($row['guestsNum'] == "2+1") {
                                $breakfast = str_repeat($breakfast, 3);
                            }
                            if($i == 0){
                                $status = "glyphicon glyphicon-log-in in status";
                            }
                            elseif($i == count($row['dates']) - 1){
                                $status = "glyphicon glyphicon-log-out out status";
                                $class ="free";
                                $breakfast = "";
                                $genious = "";
                                $id = $date;
                                $div="out-box";
                            }
                            else {
                                $status = "glyphicon glyphicon-bed status";
                            }
                            $guestName = $row['guestName']; 
                        }
                    }
                }
            }
                        echo "
                        <td id='{$key}' class='{$class} booking-cell' title='{$id}'>
                        <span class='{$genious}'></span>    {$breakfast}
                        <br>
                        <div class='in-box'>
                        <span class='{$deposit}'></span>
                        <span class='{$status}'></span>
                        {$guestName}
                        </div>
                        </td>";
        }
        echo "</tr>";
    }
}

function year(){
    if(isset($_GET['year'])){
        $year = $_GET['year'];
    }
    else {
        $year = date("Y");
    }
    return $year;
}
function selectDate($day, $type, $setDay = 0){
     for($i=1; $i<32; $i++){
        if($setDay == 0){
            $setDay = date("d");
        }
        if($type == "index"){
            if($i ==$setDay+$day && !isset($_GET['start_day'])) {
                $selected = "selected";
            }
            elseif($i == $_GET['start_day']){
                 $selected = "selected";
            }
            else {
                $selected = "";
            }
        }
        else {
            if($i == $setDay +$day) {
                $selected = "selected";
            }
               else {
                $selected = "";
            }
        }
        echo  "<option {$selected}>{$i}</option>";
     }
}
function isChecked($value){
    if($value == 1){
        echo "checked";
    }
}
function selectMonth($month = 0){
    global $months;
    if($month == 0){
        $month = date("m");
    }
    for($i=1; $i<13; $i++){
           if($i == intval($month)) {
                $selected = "selected";
            }
            else{
                $selected = "";
            }
        $monthName = $months[$i-1];
        echo "<option {$selected} value='{$i}'>{$monthName}</option>";
    }
}
function getMonthName($month = 0){
    global $months;
    if($month == 0){
        $month = date("m");
    }
    foreach($months as $key => $value){
        if(intval($month) == $key + 1){
            $current_month = $value; 
        }
    }
    return $current_month;
}
function selectRoom($room = 1){
    global $rooms;
    echo "<option value='0' disabled>Выберите номер</option>";
    for($i=0; $i<count($rooms); $i++){
        $roomNum = $i + 1;
        if($room == $roomNum){
            $selected = "selected";
        }
        else {
            $selected = "";
        }
        echo "<option value='{$roomNum}' {$selected}>{$rooms[$i]}</option>";
    }
}
function selectGuests($guests = 1){
    for($i=1; $i<5; $i++){
        if($guests == $i){
            $selected = "selected";
        }
        else {
            $selected = "";
        }
        echo "<option value='{$i}' {$selected}>{$i}</option>";
    }
}
function onlyAdmin(){
    authCheck();
    if($_SESSION['status'] != "main"){
        header("location:index.php");
    }
}
function getServicesAmount($id){
    global $link;
    $servicesAmount = $link->query("SELECT SUM(price) as total FROM services WHERE b_id = {$id}")->fetch_array()['total'];
    if(!$servicesAmount ){
        $servicesAmount = 0;
    }
    return $servicesAmount;

}
function getDepositsAmount($date){
    global $link;
    $deposit = 300;
    $depositGates = 500;
    $amount = 0;
    $date = date_format(date_create($date), "Y-m-d");
    $select = $link->query("SELECT guestName, roomNum, deposit, depositGates FROM booking WHERE ('{$date}' BETWEEN dateStart AND dateEnd) AND (deposit = 1 OR depositGates = 1)");
    $count = mysqli_num_rows($select);
    if($count > 0){
        while($row = $select->fetch_array()){
            if($row['deposit'] && $row['depositGates']){
                $amount += $deposit + $depositGates;
                $count += 1;
            }
            else{
                if($row['deposit']){
                    $amount += $deposit;
                }
                else{
                    $amount += $depositGates;
                }
            }
        }
    }
   return [$count, $amount];
}
function getDeposits($date){
    global $link;
    $deposit = 300;
    $depositGates = 500;
    $date = date_format(date_create($date), "Y-m-d");
    $select = $link->query("SELECT guestName, roomNum, deposit, depositGates FROM booking WHERE ('{$date}' BETWEEN dateStart AND dateEnd) AND (deposit = 1 OR depositGates = 1)");
    if(mysqli_num_rows($select) > 0){
        while($row = $select->fetch_array()){
            if($row['deposit'] && $row['depositGates']){
                echo "<tr><td>{$row['roomNum']}</td><td>{$row['guestName']}</td><td>залог за ключ</td><td>{$deposit} руб.</td></tr>";
                echo "<tr><td>{$row['roomNum']}</td><td>{$row['guestName']}</td><td>залог за ключ от ворот</td><td>{$depositGates} руб.</td></tr>";
            }
            else{
                if($row['deposit']){
                    $depositType = "Залог за ключ";
                    $depositSum = $deposit;
                }
                else{
                    $depositType = "Залог за ключ от ворот";
                    $depositSum = $depositGates;
                }
                echo "<tr><td>{$row['roomNum']}</td><td>{$row['guestName']}</td><td>{$depositType}</td><td>{$depositSum} руб.</td></tr>";
            }
        }
    }
}

function getUserPayments($id){
    global $link;
    $payed = $link->query("SELECT SUM(amount) as total FROM payments WHERE bookingId ={$id} AND name not LIKE '%залог%' AND status = '+'")->fetch_array()['total'];
    $returned = $link->query("SELECT SUM(amount) as total FROM payments WHERE bookingId ={$id} AND status = '-'")->fetch_array()['total'];
    $total = $payed - $returned;
    return $total;
}
function getDebt($id, $amount){
    $toPay = $amount + getServicesAmount($id) - getUserPayments($id);
    return $toPay;
}
function permissionControl(){
    if($_SESSION['status'] == "admin"){
        $class = "hidden";
    }
    else{
        $class = "";
    }
    return $class;
}
function selectPayments($payment = "0"){
    global $payments;
    for($i = 0; $i < count($payments);$i++){
        if($payment == $payments[$i]){
            $selected = "selected";
        }
        else{
            $selected = "";
        }
        echo "<option {$selected} value='{$payments[$i]}'>{$payments[$i]}</option>";
    }
}
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
function getRoomType($roomNum) {
    if($roomNum == 1) {
        $roomType = "Standart";
    }
    elseif($roomNum == 3) {
        $roomType = "Standart";
    }
    else{
        $roomType = "Improved";  
    }
    return $roomType;
}
function getGuestsNum($guestsNum, $roomType){
    if(strlen($guestsNum) > 2) {
            $guestsNum = 0;
            $extraPlace = 1;
        }
    else {
        if($roomType == "Improved") {
            $guestsNum = 0;
        }
        $extraPlace = 0;
    }
    return array('guestsNum'=>$guestsNum, 'extraPlace'=>$extraPlace);
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
function getDaysCount($from, $to){
    $from = date_create($from);
    $to = date_create($to);
    return date_diff($from, $to)->format('%a');
}
function getPrice($date, $sql){
    global $link;
//    echo $sql;
    $query = $link->query($sql);
//    echo $sql;
     while($row = $query->fetch_array()) {
        if($date >= $row['date']){
            $price = $row['price'];
        }
    }
    return $price;
}
function formatDate($date) {
    if(strlen($date) < 2) {
        $date = "0".$date;
    }
    return $date;
}
function isEmpty($input){
    if(isset($_POST[$input])){
        return $_POST[$input];
    }
    else{
        return 0;
    }
}
function getCheckbox($input){
    if(isset($input)){
        return 1;
    }
    else{
        return 0;
    }
}
function makeDateArray($date, $period, $order = "dateStart"){
    global $link;
    $dateStart = date_format(date_create($date), "Y-m-d");
    $dateEnd = new DateTime($dateStart);
    $dateEnd->modify("+{$period} day");
    $dateEnd =date_format($dateEnd, "Y-m-d");
    $query = $link->query("SELECT id, roomNum, dateStart, dateEnd, guestName, guestsNum, Genious, priceChange, guestPhone, breakfast, deposit, amount, checkIn FROM booking WHERE (canceled = 0) AND (('{$dateEnd}' BETWEEN dateStart AND dateEnd) OR ('{$dateStart}' BETWEEN dateStart AND dateEnd) OR (dateStart >='{$dateStart}' AND dateStart <='{$dateEnd}') OR (dateEnd >='{$dateStart}' AND dateEnd <='{$dateEnd}')) ORDER BY {$order} ASC");
//    echo "SELECT id, roomNum, dateStart, dateEnd, guestName, guestsNum, Genious, priceChange, guestPhone, breakfast, deposit, amount, checkIn FROM booking WHERE (canceled = 0) AND (('{$dateEnd}' BETWEEN dateStart AND dateEnd) OR ('{$dateStart}' BETWEEN dateStart AND dateEnd) OR (dateStart >='{$dateStart}' AND dateStart <='{$dateEnd}') OR (dateEnd >='{$dateStart}' AND dateEnd <='{$dateEnd}')) ORDER BY {$order} ASC";

   
//echo "SELECT id, roomNum, dateStart, dateEnd, guestName, guestsNum, Genious, priceChange, guestPhone, breakfast, deposit FROM booking WHERE (canceled = 0) AND (('{$dateEnd}' BETWEEN dateStart AND dateEnd) OR ('{$dateStart}' BETWEEN dateStart AND dateEnd) OR (dateStart >='{$dateStart}' AND dateStart <='{$dateEnd}') OR (dateEnd >='{$dateStart}' AND dateEnd <='{$dateEnd}')) ORDER BY {$order} ASC";
    $dates = [];
    $i = 0;
    while($row = $query->fetch_array()){ 
//        echo $row['dateStart'];
        array_push($dates, $i);
        $dates[$i] = [];
        $period = allDatesInPeriod($row['dateStart'], $row['dateEnd'], 1);
        $dates[$i]['id'] = $row['id'];
        $dates[$i]['dates'] = $period;
        $dates[$i]['roomNum'] = $row['roomNum'];
        $dates[$i]['Genious'] = $row['Genious'];
        $dates[$i]['dateStart'] = $row['dateStart'];
        $dates[$i]['breakfast'] = $row['breakfast'];
        $dates[$i]['priceChange'] = $row['priceChange'];
        $dates[$i]['guestPhone'] = $row['guestPhone'];
        $dates[$i]['guestName'] = $row['guestName'];
        $dates[$i]['guestsNum'] = $row['guestsNum'];
        $dates[$i]['deposit'] = $row['deposit'];
        $dates[$i]['amount'] = $row['amount'];
        $dates[$i]['checkIn'] = $row['checkIn'];
        
        $i++;
    }
//    foreach($dates as $date){
//        for($i=0;$i<count($date['dates']);$i++){
//            echo $date['dates'][$i].", ";
//        }
//        echo "roomNum: ".$date['roomNum']."<br>";
//    }
    return $dates;
}
function todayInfo(){
    global $link;
    $date = date("d.m.Y");
    $period = 1;
    $array = makeDateArray($date, $period, "roomNum");
    foreach($array as $pole){
        for($i = 0; $i < count($pole['dates']); $i++){
            if($pole['dates'][$i] == date("Y-m-d")){
                $not_arrived = false;
                $button = "";
                $warning = "";
                $debtClass ="hidden";
                $debtText="";
                $query = $link->query("SELECT checkIn, messageSent FROM booking WHERE id = {$pole['id']}");
                $query = $query->fetch_array();                
                //checkInn btn
                if($i >= 1 && $query['checkIn'] == 0){
                        $warning = "red";
                        $current_time = date("H:i");
                        $deadline = date("H:i", strtotime("09:00"));
                        if($current_time >= $deadline){
                            $not_arrived = true;
                            if($query['messageSent'] == 0){ //if message havent been sent
                            $to = "marviv74@gmail.com";
                            $charset = "windows-1251";
                            $subject = "Гость {$pole['guestName']} не заехал";
                            $message = " Кажется, кто-то передумал заезжать. Уже 9 часов, а гость {$pole['guestName']} так и не заехал(заезд {$pole['dateStart']} в номер {$pole['roomNum']})!\n Отмените бронь в системе бронирования и поставьте незаезд в букинге";
                            $from = "hotel-welcome@yandex.ru";
                            $send = mail($to,$subject,$message, "from:" . $from);
//                            echo $message;
                            $link->query("UPDATE booking SET messageSent = 1 WHERE id = {$pole['id']}");
                            }
                            
                        }
                }
                if($query['checkIn'] == 0){
                    $button =  "<button id='{$pole['id']}' class='btn btn-warning checkIn todayButton' name='checkIn'>Подтвердить заезд</button>";
                }
                else {
                    $button =  "<span class='green glyphicon glyphicon-ok' name='checkIn'></span>";
                }
                
                //host action
                if($query['checkIn'] == 1){
                    $debtAmount = getDebt($pole['id'], $pole['amount']);
                    if($debtAmount > 0){
                            $debtClass = "text-red";
                            $debtText = "Задолженность: {$debtAmount}";
                    }   
                }
                switch($i) {
                    case 0:
                        $action = "Заезд";
                        break;
                    case count($pole['dates'])-1:
                        $action = "Выезд";
                        if($pole['deposit'] == 1){
                            $button .= "<button id='{$pole['id']}' class='btn btn-warning todayButton btn-deposit' name='deposit' value='{$pole['guestName']}'>Вернуть залог</button>";
                        }
                        break;
                    default:
                        
                        $action = "проживает";
                        break;
                }
                if($not_arrived){
                    $action = "не заехал гость";
                    $button = "<a href='actions.php?id={$pole['id']}&action=cancel' class='btn btn-alarm'></a>";
                }
                echo "<p>Номер {$pole['roomNum']} <span class='glyphicon glyphicon-arrow-right'></span><span              class='{$warning}'> {$action} <a class='booked_pole' title='{$pole['id']}'>{$pole['guestName']}</a> </span> {$button}  <span class='{$debtClass}'>{$debtText} руб.</span></p>";
            }
        }       
    }
}
function getPrePayGuests(){
    global $link;
    $today = date("Y-m-d");
    $week =  date_format(date_modify(date_create(), '7days'), "Y-m-d");
    $select = $link->query("SELECT * FROM booking  WHERE (payment='Предавторизация платежа') AND (dateStart BETWEEN '{$today}' AND '{$week}') AND (canceled = 0)");
    //echo "SELECT * FROM booking b, payments p WHERE (payment='Предавторизация платежа') AND (dateStart BETWEEN '{$today}' AND '{$week}') AND b.id = p.b_id "
    while($row = $select->fetch_array()){
        $payed = $link->query("SELECT SUM(amount) as total FROM payments WHERE bookingId = {$row['id']}")->fetch_array();
        if($payed['total'] == 0){
            $date = date_format(date_create($row['dateStart']), "d.m.Y");
            echo "Предавторизация <a class='booked_pole' title='{$row['id']}'>{$row['guestName']}</a> (заезд {$date}) <button class='btn btn-small btn-default pre-pay' title='{$row['id']}' >Списать предоплату</button>";
        }
}
}
function getWorkDay($type, $day, $time){
        if($day != 0){
        $start = date_format(date_modify(date_create(date("Y-m-d")." 11:00"), "+{$day} day"),"Y-m-d H:i");
        $end = date_format(date_modify(date_create($start), "+1 day"),"Y-m-d H:i");
            echo $start ." - ". $end;
    }
    else{
        //check the current time, and if it is more, than 11, it means that shift is started this day
        if(date("H:i") > $time){
            $start = date("Y-m-d")." ".$time;
            $end = date_format(date_modify(date_create($start), "+1 day"),"Y-m-d H:i");
            $current = date_format(date_create($start), "Y-m-d");
                echo $start ." - ". $end;
        }
        else { // if time is less than 11, shift started previous day
            $end = date("Y-m-d")." ".$time;
            $start = date_format(date_modify(date_create($end), "-1 day"),"Y-m-d H:i");
                echo $start ." - ". $end;
        }
    }
    return [$start, $end];
}
function listOfServices(){
    global $link;
    $array = [];
    $select = $link->query("SELECT * FROM services_list")->fetch_all(MYSQLI_ASSOC);
    return $select;
}
function getServices($id){
    global $link;
    $select = $link->query("SELECT * FROM services WHERE b_id = {$id}");
    while($row = $select->fetch_array()){
        if($row['quantity'] == 1){
            $row['quantity'] = "";
        }
        else{
            $row['quantity'] .= " шт.";
        }
        echo "<li>{$row['name']} {$row['quantity']} - {$row['price']} <button name='deleteService' value='{$row['id']}' class='btn btn-danger btn-small service-delete hidden'>Удалить</button></li>";
    }
}
function getPayments($type, $day = 0, $time = "11:00"){
    global $link;
    $boarders = getWorkDay($type, $day, $time);
    $query = $link->query("SELECT * FROM payments WHERE (DATE_FORMAT(date, '%Y-%m-%d H:i') BETWEEN '{$boarders[0]}' AND '{$boarders[1]}') AND status = '{$type}'");
    $array = $query->fetch_array();
    return $array;
}
function getTotal($type, $day = 0, $time = "11:00"){
    global $link;
    $boarders = getWorkDay($type, $day, $time);
    $sum = $link->query("SELECT type, SUM(amount) as total FROM payments WHERE (DATE_FORMAT(date, '%Y-%m-%d H:i') BETWEEN '{$start}' AND '{$end}') AND status = '{$type}' GROUP BY type");
    $array = $sum->fetch_array();
    return $array;
}
function getBalance($type, $day = 0, $time = "11:00"){
    global $link;
    $boarders = getWorkDay($type, $day, $time);
    $total = $link->query("SELECT MAX(total) - MIN(total) as total FROM (SELECT status, SUM(amount) as total FROM payments WHERE (DATE_FORMAT(date, '%Y-%m-%d H:i') BETWEEN '{$start}' AND '{$end}') AND type = 'Наличные' GROUP BY status)tmp");
    $total = $total->fetch_array()['total'];
    return $total;  
}
function paymentsTablePlus($type, $day = 0, $time = "11:00"){
    global $link;
    $profit_sum = 0;
    $profit_sum = 0;
    if($day != 0){
        $start = date_format(date_modify(date_create(date("Y-m-d")." 11:00"), "+{$day} day"),"Y-m-d H:i");
        $end = date_format(date_modify(date_create($start), "+1 day"),"Y-m-d H:i");
            echo $start ." - ". $end;
    }
    else{
        //check the current time, and if it is more, than 11, it means that shift is started this day
        if(date("H:i") > $time){
            $start = date("Y-m-d")." ".$time;
            $end = date_format(date_modify(date_create($start), "+1 day"),"Y-m-d H:i");
            $current = date_format(date_create($start), "Y-m-d");
                echo $start ." - ". $end;
        }
        else { // if time is less than 11, shift started previous day
            $end = date("Y-m-d")." ".$time;
            $start = date_format(date_modify(date_create($end), "-1 day"),"Y-m-d H:i");
                echo $start ." - ". $end;
        }
    }
    $query = $link->query("SELECT * FROM payments WHERE (DATE_FORMAT(date, '%Y-%m-%d H:i') BETWEEN '{$start}' AND '{$end}') AND status = '{$type}'");
    $sum = $link->query("SELECT type, SUM(amount) as total FROM payments WHERE (DATE_FORMAT(date, '%Y-%m-%d H:i') BETWEEN '{$start}' AND '{$end}') AND status = '{$type}' GROUP BY type");
    
    $total = $link->query("SELECT MAX(total) - MIN(total) as total FROM (SELECT status, SUM(amount) as total FROM payments WHERE (DATE_FORMAT(date, '%Y-%m-%d H:i') BETWEEN '{$start}' AND '{$end}') AND type = 'Наличные' GROUP BY status)tmp");
//    $theBalance = $link->query("INSERT into payments `name`, `status`, `type`, `amount`) VALUES ('Остаток', '+', 'Наличные', {$balance})"); 
    echo "SELECT * FROM payments WHERE (DATE_FORMAT(date, '%Y-%m-%d H:i') BETWEEN '{$start}' AND '{$end}') AND status = '{$type}'";
    

    echo "<tbody>";
    while($row = $query->fetch_array()){
        $date = date_create($row['date']);
        $date = date_format($date, "H:i");   
        echo "<p>{$row['name']} {$row['whoPay']}, {$date}, {$row['amount']}  - {$row['type']}</p>";
    }
    echo "</tbody></table>";
    while($row = $sum->fetch_array()){
        echo "<p>{$row['type']} - {$row['total']} </p>";
    }
    echo "Остаток в кассе: ".$total->fetch_array()['total'];
}
function checkAuth() {
    if(!isset($_SESSION['id'])){
        header("location:auth.php");
    }
}

class dayBalance{
    function __construct($day, $time = "11:00"){
        if($day != 0){
            global $link;
            if(date("H:i") < $time){
                $day += 1;
            }
            $start = date_format(date_modify(date_create(date("Y-m-d")." 11:00"), "-{$day} day"),"Y-m-d H:i");
            $end = date_format(date_modify(date_create($start), "+1 day"),"Y-m-d H:i");
            $this->startDay = $start;
            $this->endDay = $end;
            $nextStart = $end;
            $nextEnd = date_format(date_modify(date_create($nextStart), "+1 day"),"Y-m-d H:i");
            $check = $link->query("SELECT * FROM payments WHERE (DATE_FORMAT(date, '%Y-%m-%d H:i') BETWEEN '{$nextStart}' AND '{$nextEnd}') AND name = 'Остаток в кассе'");
            $balance = $this->getBalance();
            if(mysqli_num_rows($check) == 0){
                $date = date_format(date_modify(date_create($this->endDay),"+1 minute"), "Y-m-d H:i");
                $insert = $link->query("INSERT INTO `payments`( `name`, `status`, `type`, `date`, `amount`, `comment`, `whoPay`, `whoAdd`) VALUES ('Остаток в кассе','+','Наличные','{$date}',{$balance},'','','auto')");
            }
            else{
                if($check->fetch_array()['amount'] != $balance){
                    $link->query("UPDATE payments SET amount = {$balance} WHERE (DATE_FORMAT(date, '%Y-%m-%d H:i') BETWEEN '{$nextStart}' AND '{$nextEnd}') AND name = 'Остаток в кассе'");
              }
            }
    }
    else{
        //check the current time, and if it is more, than 11, it means that shift is started this day
        if(date("H:i") >= $time){
            $start = date("Y-m-d")." ".$time;
            $end = date_format(date_modify(date_create($start), "1day"),"Y-m-d H:i");
            $current = date_format(date_create($start), "Y-m-d");
        }
        else { // if time is less than 11, shift started previous day
            $end = date("Y-m-d")." ".$time;
            $start = date_format(date_modify(date_create($end), "-1day"),"Y-m-d H:i");
        }
    }
    $this->startDay = $start;
    $this->endDay = $end;
    }
    
    function getPayments($type){
        global $link;
        $array = array();
        $query = $link->query("SELECT * FROM payments WHERE (date BETWEEN '{$this->startDay}' AND '{$this->endDay}') AND status = '{$type}' ORDER by date");
//        $array = $query->fetch_all();
        while($row = $query->fetch_array()){
            array_push($array,$row);
        }
        return $array;
    }
    
    function getTotal($type){
        global $link;
        $array = [];
        $sum = $link->query("SELECT type, SUM(amount) as total FROM payments WHERE (date BETWEEN '{$this->startDay}' AND '{$this->endDay}') AND status = '{$type}' GROUP BY type");
        while($row = $sum->fetch_array()){
            array_push($array,$row);
        }

        return $array;
    }
    function getBalance(){
        global $link;
        $total = $link->query("SELECT status, SUM(amount) as total FROM payments WHERE (date BETWEEN '{$this->startDay}' AND '{$this->endDay}') AND type = 'Наличные' GROUP BY status");
            $profit = 0;
            $costs = 0;
            while($row = $total->fetch_array()){
                if($row['status'] == "+"){
                    $profit = $row['total'];
                }
                else{
                    $costs = $row['total'];
                }
            }
            $total = $profit - $costs;

        return $total;  
    }
}
function daysInMonth($date){
    $date = date_create($date);
    $month = intval(date_format($date, "m"));
    $year = intval(date_format($date, "Y"));
    if(($year % 4 == 0 and $year % 100 != 0) or ($year % 400 == 0)){
        $vis = 1;
    }
    else{
        $vis = 0;
    }
    switch($month){
    case 2:
      $days = 28 + $vis;
      break;
    case 1:
    case 3:
    case 5:
    case 7:
    case 8:
    case 10:
    case 12:
      $days = 31;
      break;
    default:
      $days = 30;
      break;
    }
    return $days;
}

class Room {
    function __construct($roomNum, $roomName, $full){
        $this->roomNum = $roomNum;
        $this->roomName = $roomName;
        $this->bookedNights = 0;
        $this->total = 0;
        $this->daysMonth = $full;
    }
    function percents(){
        $this->percents = round($this->bookedNights / $this->daysMonth, 3) *100;
        return $this->percents;
    }
}
class RoomLoading {
   function __construct($date){
       global $rooms;
       $from = "01.".date_format(date_create($date),"m.Y");
       $days = daysInMonth($from);
       $to = date_format(date_modify(date_create($from), "{$days} days"), "Y-m-d");
       $booking = makeDateArray($from, $days, "dateStart");
       $dates = allDatesInPeriod($from, $to);
       
       $this->dayInMonth = daysInMonth($dates[0]);
       $this->fullLoading = count($rooms) * $this->dayInMonth;
       $this->totalLoad = 0;
       $this->loading_list = [];
       foreach($rooms as $key => $room) {
           $key += 1;
           $item = new Room($key, $room, $this->dayInMonth);
            array_push($this->loading_list, $item);
       }
        foreach($dates as $date) {
            foreach($rooms as $key => $room) {
                foreach($booking as $row){
                    if(intval($key)+1 == intval($row['roomNum'])){
                        $date = date_format(date_create($date), "Y-m-d");
                        for($i = 0; $i < count($row['dates']); $i++){
                            if($date == $row['dates'][$i]){
                                if($row['checkIn'] == 1){
                                    if($i != count($row['dates']) - 1){
                                        $this->loading_list[$key]->bookedNights += 1;
                                        $this->totalLoad += 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    function percents(){
        $this->percents = round($this->totalLoad /$this->fullLoading, 3) * 100;
        return $this->percents;
    }
}
function money($int){
    $value = number_format($int, 2, ',', ' '). " руб.";
    return $value;
}
function getBookingBalance($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $current_date = date("Y-{$month}")."-01";
    $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");
    $booking_revenue = $link->query("SELECT b_sum as book, s_sum as serv, b_sum + s_sum as total FROM 
(SELECT sum(amount) as b_sum from booking where (dateStart BETWEEN '{$current_date}' AND '{$end_of_month}') AND (canceled = 0) AND (checkIn = 1)) as book, 
(SELECT sum(price) as s_sum from services where (date BETWEEN '{$current_date}' AND '{$end_of_month}')) as serv")->fetch_array();
    return $booking_revenue;
}
function getPaymentsBalance($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $current_date = date("Y-").$month."-01";
    $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");
    $income_revenue = $link->query("SELECT m_sum - first as total FROM (SELECT SUM(amount) as m_sum from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '{$current_date}' AND '{$end_of_month}') AND (NOT name = 'Остаток в кассе') AND (NOT name = 'внесение в кассу') AND (status = '+')) total, (SELECT amount as first FROM payments WHERE DATE_FORMAT(date, '%Y-%m-%d') = '{$current_date}' AND name = 'Остаток в кассе') first_p")->fetch_array();
//    echo "SELECT m_sum - first as total FROM (SELECT SUM(amount) as m_sum from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '{$current_date}' AND '{$end_of_month}') AND (NOT name = 'Остаток в кассе') AND (NOT name = 'внесение в кассу') AND (status = '+')) total, (SELECT amount as first FROM payments WHERE DATE_FORMAT(date, '%Y-%m-%d') = '{$current_date}' AND name = 'Остаток в кассе') first_p";
    return $income_revenue;
}
function getFuturePayments($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $end_of_month = date("Y")."-".$month."-31";
    $start_of_month = date("Y")."-".$month."-01";
    $revenue = $link->query("SELECT SUM(p.amount) as total FROM payments p INNER JOIN booking b ON bookingId = b.id WHERE (date BETWEEN '{$start_of_month}' AND '{$end_of_month}') AND (dateStart > '{$end_of_month}')")->fetch_array();
    
    if($revenue){
        return $revenue['total'];
    }
    else{
        return 0;
    }

}
function getPastPayments($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $end_of_month = date("Y")."-".$month."-31";
    $start_of_month = date("Y")."-".$month."-01";
    $revenue = $link->query("SELECT SUM(p.amount) as total FROM payments p INNER JOIN booking b ON bookingId = b.id WHERE (date BETWEEN '{$start_of_month}' AND '{$end_of_month}') AND (dateStart < '{$start_of_month}')")->fetch_array();
    
    if($revenue){
        return $revenue['total'];
    }
    else{
        return 0;
    }
}

function isRoomFree($room, $dateStart, $dateEnd){
    global $link; 
    $dateStart = date_format(date_create($dateStart), "Y-m-d");
    $dateStart1 = date_format(date_modify(date_create($dateStart), '+1 day'), "Y-m-d");
    $dateEnd1 = date_format(date_create($dateEnd), "Y-m-d");
    $dateEnd = date_format(date_modify(date_create($dateEnd), '- 1 day'), "Y-m-d");
    $sql = "SELECT * FROM booking WHERE (roomNum = {$room}) AND (('{$dateStart}' >= dateStart AND '{$dateStart}' < dateEnd) OR ('{$dateEnd1}' > dateStart AND '{$dateEnd1}' <= dateEnd) OR (dateStart >= '{$dateStart}' AND dateStart < '{$dateEnd1}') OR (dateEnd >= '{$dateStart1}' AND dateEnd < '{$dateEnd1}')) AND (canceled = 0)";
    $control = $link->query($sql);
//    echo $sql;
    if(mysqli_num_rows($control) > 0){
        while($row = $control->fetch_array()){
            echo "{$row['dateStart']} - {$row['dateEnd']} проживает {$row['guestName']} <br>";
        }
        return false;
    }
    else{
        return True;
    }
}
function getBookingComission($month){
    global $link; 
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $end_of_month = date("Y")."-".$month."-31";
    $start_of_month = date("Y")."-".$month."-01";
    $revenue = $link->query("SELECT SUM(p.amount)*0.15 as total FROM payments p INNER JOIN booking b ON bookingId = b.id WHERE (date BETWEEN '{$start_of_month}' AND '{$end_of_month}') AND (source = 'booking')")->fetch_array();
    return $revenue['total'];
}
function getBalanceByPaymentTypes($month){
        global $link;
        if(strlen($month) == 1){
            $month = "0".$month;
        }
        $current_date = date("Y")."-".$month."-01";
        $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");
        $payment_types = $link->query("SELECT type, SUM(amount) as total from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '{$current_date}' AND '{$end_of_month}') AND (NOT name = 'Остаток в кассе') AND (NOT name = 'внесение в кассу') AND (status = '+') GROUP BY type");
        $first_day = $link->query("SELECT amount as first FROM payments WHERE DATE_FORMAT(date, '%Y-%m-%d') = '{$current_date}' AND name = 'Остаток в кассе'")->fetch_array();
        while($row = $payment_types->fetch_array()){
            if($row['type'] == "Безналичный расчет"){
                $cashless = $row['total'];
            }
            else {
                $cash = $row['total'];
            }
        }
        if(!isset($cashless)){
            $cashless = 0;
        } 
        if(!isset($cash)){
            $cash = 0;
        }
        $cash -= $first_day['first'];
        return ["cash" => $cash, "cashless" => $cashless];
}
?>
