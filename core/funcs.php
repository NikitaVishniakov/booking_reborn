<?php
//if(!isset($_SESSION['id'])){
//    session_start();
//}
require_once($_SERVER['DOCUMENT_ROOT'].'/core/config.php');
require_once(CORE . "connection.php");
require_once(CORE . 'funcs.php');
date_default_timezone_set('Europe/Moscow');
$categories = [1=>'Стандарт', 2=>'Улучшенный'];
$rooms = [1=>[1=>'1',3=> '3'],2=>[2=>'2',4=>'4',5=>'5']];
$guestsNum = array(1=>['1','2'], 2=>['1', '2', '2+1'], 3=>['1', '2'], 4=>['1', '2','2+1'], 5=>['1','2']);
$sources = ["Booking", "Ostrovok", "Постоянщик", "С улицы", "Другое"];
$months =['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентрябрь','Октябрь','Ноябрь','Декабрь'];
$periods = array(7=>'Неделя',14=>'Две недели',31=>'Месяц');
$payments = ['Оплата при заселении', 'Предоплата'];
$pay_types = ['Наличные', 'Безналичный расчет'];
$prolongation_cost_types = [1=>'Час/Стоимость ночи(по бронированию)',2=>'Час/Стоимость ночи(по тарифу)',3=>'Фиксированная цена'];
$cleanTheRoom = 3;
$users = ['admin' => 'Администратор', 'main' => 'Управляющий'];

function getRoomsList(){
    global $link;
    $result = $link->query("SELECT * FROM rooms");
    $arr = [];
    while($row = $result->fetch_array()){
        if(!isset($arr[$row['CATEGORY_ID']])){
            $arr[$row['CATEGORY_ID']] = [];
        }
        array_push($arr[$row['CATEGORY_ID']],$row['NAME']);
    }
    return $arr;
}

function getUserStatusList($choosen = ''){
    global $users;

    foreach($users as $status => $name){
        $selected = '';
        if($choosen == $status){
            $selected = 'selected';
        }
        $arrOptions[] = "<option $selected value='$status'>$name</option>";
    }

    return $arrOptions;
}
function getRoomCategory($room){
    $rooms = getRoomsList();
    foreach ($rooms as $key =>$val){
        if(in_array($room, $val)){
            return $key;
        }
    }
}
function getCategoriesList()
{
    global $link;
    $result = $link->query("SELECT * FROM categories");
    $arr = [];
    while ($row = $result->fetch_array()){
        $arr[$row['ID']] = $row['CATEGORY'];
    }
    return $arr;
}
function getRoomNames(){
    $categories = getCategoriesList();
    $rooms = getRoomsList();
    $array = [];
    foreach ($categories as $key => $value){
        foreach ($rooms as $cat=>$room){
            if ($cat == $key){
                foreach ($room as $id => $name){
                    $roomName = $value . " № " . $name;
                    $array[$name] = $roomName;
                }
            }
        }
    }
    return($array);
}

function hotelHasDebt(){
    $hotel = $_SESSION['HOTEL']['ID'];
}

function getSeparatedRoomNames(){
    $categories = getCategoriesList();
    $rooms = getRoomsList();
    $array = [];
    foreach ($categories as $key => $value){
        foreach ($rooms as $cat=>$room){
            if ($cat == $key){
                foreach ($room as $id => $name){
                    $roomName = array('category' => $value, 'room' => " № " . $name);
                    $array[$name] = $roomName;
                }
            }
        }
    }
    return($array);
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

function selectRoom ($category, $chosen = 1){
    $rooms = getRoomsList();
    $categories = getCategoriesList();
    foreach($rooms[$category] as $key => $room){
        if($chosen == $room){
            $selected = "selected";
        }
        else {
            $selected = "";
        };
        echo "<option $selected value='{$room}'>{$categories[$category]} № $room </option>";
    }
}

function selectCategory($chosen = 1){
    $categories = getCategoriesList();
    foreach($categories as $key => $category){
        if($chosen == $key){
            $selected = "selected";
        }
        else {
            $selected = "";
        };
        echo "<option $selected value='{$key}'>{$category}</option>";
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
function selectPaymentName($plus, $name = ''){

    $payments = models\Booking::getElementList('payment_types', array(), " type='$plus'");

    foreach($payments as $payment){
            if(!$payment['admin_only'] || isAdmin()) {
                if ($payment['id'] == $name or $payment['name'] == $name) {
                    $select = "selected";
                } else {
                    $select = "";
                }
                echo "<option $select value='{$payment['name']}'>{$payment['name']}</option>";
            }
    }
}
function debug($var){
    echo "<pre>".print_r($var, true)."</pre>";
}
function selectGetUnity(){
    global $link;
    $sql = "SELECT * FROM costs_units";
    $units = $link->query($sql);
    while ($unit = $units->fetch_array()){
        echo "<option value='{$unit['NAME']}'>{$unit['NAME']}</option>";
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

function selectPaymentTypeBooking($selected = ""){
    global $payments;
    foreach($payments as $type){
        if($selected == $type){
            $select = "selected";
        }
        else{
            $select = "";
        }
        echo "<option $select value='$type'>$type</option>";
    }
}

function accessControl(array $groups){
    if(!in_array($_SESSION['status'], $groups)){
        http_response_code(404);
        header('location: /admin/not_found');
        die();
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
        header("location:/admin/Users/auth");
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
                    header("location: incomes.php");
                }
                else {
                    $_SESSION['error'] = "Неверно указан логин или пароль";
                }
}

//количество дней в месяце
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


function separateThousands($number, $currency = ''){

    $decimals = is_float($number) ? 2 : 0;
    return number_format($number, $decimals, ', ', ' ') . " " .$currency;
}


function dataCount($date, $period) {
        $from = date_format(date_create($date),"Y-m-d");
        $to = new DateTime($from);
        $to = $to->modify("+{$period} day");
        $to = strval($to->format("Y-m-d"));
        $dates = allDatesInPeriod($from, $to);
        return $dates;

}

function tableRoom($dates){
    foreach($dates as $date) {
        $th_date = date_format(date_create($date), "d.m.Y");
        echo "<th>{$th_date}</th>";
    }
}
function divDates($dates){
    $arrDates = [];
    foreach($dates as $key => $date) {
        $arrDates[$key] = date_format(date_create($date), "d.m");
    }
    return $arrDates;
}
function divRooms()
{
    $rooms = getSeparatedRoomNames();

    return $rooms;
}
function bookingContainerFill($dates, $booking){
    global $link;

    $hourStart = $link->query("SELECT PROLONGATION_HOURS_START FROM settings")->fetch_array()['PROLONGATION_HOURS_START'];

    $rooms = getRoomNames();
    $arrBookings = [];

    foreach($rooms as $key => $room) {
        $category = getRoomCategory($key);
        $counter = 0;
        foreach($dates as $date) {
            $class = 'free';
            $id = $date;
            $status = "";
            $guestName = "";
            $genious = "";
            $breakfast = "";
            $div = "";
            $deposit = "";
            $href = "javascript:void(0)";
            foreach($booking as $row){
                if(intval($key) == intval($row['roomNum'])){
                    $room = $row['roomNum'];
                    $date = date_format(date_create($date), "Y-m-d");

                    for($i = 0; $i < count($row['dates']); $i++){
                        if($date == $row['dates'][$i]){
                            $guestName = $row['guestName'];

                            $id = $row['id'];
                            $class = "booked";
                            $href = "/admin/booking_page/$id";
                            if($row['dates'][0] <= date('Y-m-d')){
                                if($row['checkIn']){
                                    if(getDebt($id, $row['amount']) > 0){
                                        $class .= " hasDebt";
                                    }
                                }
                            }
                            if($row['Genious'] == 1){
                                $genious = "fa fa-thumbs-o-up status";
                            }
                            if($row['breakfast'] == 1){
                                $breakfast ="<i class='fa fa-cutlery' aria-hidden='true'></i>";
                            }
                            if($row['guestsNum'] == "2"){
                                $breakfast = str_repeat($breakfast, 2);
                            }
                            if($row['deposit'] == 1){
                                $deposit = "fa fa-key";
                            }
                            elseif($row['guestsNum'] == "2+1") {
                                $breakfast = str_repeat($breakfast, 3);
                            }
                            if($i == 0){
                                $status = "fa fa-sign-in";
                                $div = "in-box";
                                $class .=" first-day";
                                if(!$row['isConfirmed']){
                                    $class .= ' not-confirmed';
                                }
                                if(!$row['isConfirmed']){
                                    $class .= ' not-confirmed';
                                }
                            }
                            elseif($i == count($row['dates']) - 1){
                                if($row['prolongation_hours']){
                                    $select = $link->query("SELECT * FROM services WHERE b_id = {$id} AND name = 'Почасовое продление'");
                                    if(mysqli_num_rows($select)){
                                        $prolongation =  $select->fetch_array();
                                        $hours = $prolongation['quantity'];
                                        $time = new DateTime($hourStart);
                                        $time = $time->modify("+$hours hours")->format('H:i');
                                        $text = "Продление до $time";
                                        $guestName .= "<br><span class='prolongation'>$text</span>";
                                    }
                                }
                                $status = "fa fa-sign-out";
                                $class ="free move-out";
                                $breakfast = "";
                                $href = "javascript:void(0)";
                                $genious = "";
                                $id = $date;
                                $div="out-box";
                            }
                            elseif($i == count($row['dates']) - 2){
                                $status = "fa fa-bed";
                                $class .=" last-day";
                                $div="out-box";
                                if(!$row['isConfirmed']){
                                    $class .= ' not-confirmed';
                                }
                            }
                            else {
                                $status = "fa fa-bed";
                                if(!$row['isConfirmed']){
                                    $class .= ' not-confirmed';
                                }
                            }

                        }

                    }
                }
            }
            $arrBookings[$key][$counter]['CLASS'] = $class;
            $arrBookings[$key][$counter]['ID'] = $id;
            $arrBookings[$key][$counter]['GENIOUS'] = $genious;
            $arrBookings[$key][$counter]['BREAKFAST'] = $breakfast;
            $arrBookings[$key][$counter]['HREF'] = $href;
            $arrBookings[$key][$counter]['DEPOSIT'] = $deposit;
            $arrBookings[$key][$counter]['DIV'] = $div;
            $arrBookings[$key][$counter]['STATUS'] = $status;
            $arrBookings[$key][$counter]['GUEST'] = $guestName;
            $arrBookings[$key][$counter]['ROOM'] = $key;
            $arrBookings[$key][$counter]['CATEGORY'] = $category;
            $counter++;
        }
    }
    return $arrBookings;

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
    $select = $link->query("SELECT id, guestName, roomNum, deposit, depositGates FROM booking WHERE ('{$date}' BETWEEN dateStart AND dateEnd) AND (deposit = 1 OR depositGates = 1)");
    $arrResult = array();
    if(mysqli_num_rows($select) > 0){
        while($row = $select->fetch_assoc()){
            if($row['deposit'] && $row['depositGates']){
                $row['depositType'] = "Залог за ключ";
                $row['depositSum'] = $deposit;
                $arrResult[] = $row;
                $row['depositType'] = "Залог за ключ от ворот";
                $row['depositSum'] = $depositGates;
                $arrResult[] = $row;
            }
            else{
                if($row['deposit']){
                    $row['depositType'] = "Залог за ключ";
                    $row['depositSum'] = $deposit;
                }
                else{
                    $row['depositType'] = "Залог за ключ от ворот";
                    $row['depositSum'] = $depositGates;
                }
                $arrResult[] = $row;
            }
        }
        return $arrResult;
    }
    else{
        return false;
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
class Booking
{
    protected static $amount;
    protected static $servicesTotal;

    public static function getDebt($id)
    {
        self::$amount = self::getAmount($id);
        $toPay = self::$amount + self::getServicesAmount($id) - self::getPaymentsTotal($id);
        return $toPay;
    }

    public static function getPaymentsTotal($id)
    {
        global $link;
        $payed = $link->query("SELECT SUM(amount) as total FROM payments WHERE bookingId ={$id} AND name not LIKE '%залог%' AND status = '+'")->fetch_array()['total'];
        $returned = $link->query("SELECT SUM(amount) as total FROM payments WHERE bookingId ={$id} AND status = '-'")->fetch_array()['total'];
        $total = $payed - $returned;
        return $total;
    }

    public static function getServicesAmount($id)
    {
        global $link;
        $servicesAmount = $link->query("SELECT SUM(price) as total FROM services WHERE b_id = {$id}")->fetch_array()['total'];
        if (!$servicesAmount) {
            $servicesAmount = 0;
        }
        return $servicesAmount;
    }

    public static function getAmount($id)
    {
        global $link;
        $totalAmount = $link->query("SELECT amount FROM booking WHERE id = {$id}")->fetch_array()['amount'];
        return $totalAmount;
    }

    public static function getGuestName($id)
    {
        global $link;
        $guestName = $link->query("SELECT booker, guestName FROM booking WHERE id = {$id}")->fetch_assoc();
        $name = strlen($guestName['guestName']) > 0 ? $guestName['guestName'] : $guestName['booker'];
        return $name;
    }

    public static function getFirstNightPrice($id)
    {
        global $link;
        return $link->query("SELECT price FROM booking WHERE id = {$id}")->fetch_assoc()['price'];
    }
}
function isAdmin(){
    if($_SESSION['status'] == "main"){
        return true;
    }
    else{
        return false;
    }
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
function selectCostCategories($chosen = 1){

    $categories = models\Costs::getElementList('costs_categories');
    foreach($categories as $category) {
            if ($chosen == $category['ID']) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $arrCategories[] = "<option {$selected} value='{$category['ID']}'>{$category['NAME']}</option>";
    }
    return $arrCategories;
}
function selectCostSubCategories($parent, $chosen = ''){
    global $link;
    $filter = "ID_CATEGORY = $parent";
    $categories = models\Costs::getElementList('costs_sub_categories', array(), $filter);
    if($categories){
        $arrCategory[] = "<option value='Без категории'>Не выбрано</option>";
        foreach ($categories as $category) {
            if ($chosen == $category['NAME']) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $arrCategory[] = "<option {$selected} value='{$category['NAME']}'>{$category['NAME']}</option>";
        }
    }
    else{
        $arrCategory[] =  "<option value='Без категории'>Нет подкатегорий</option>";
    }
    return $arrCategory;
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
    $query = $link->query("SELECT * FROM booking WHERE (canceled = 0) AND (('{$dateEnd}' BETWEEN dateStart AND dateEnd) OR ('{$dateStart}' BETWEEN dateStart AND dateEnd) OR (dateStart >='{$dateStart}' AND dateStart <='{$dateEnd}') OR (dateEnd >='{$dateStart}' AND dateEnd <='{$dateEnd}')) ORDER BY {$order} ASC");
    $dates = [];
    $i = 0;
    while($row = $query->fetch_array()){
//        echo $row['dateStart'];
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
        $dates[$i]['isConfirmed'] = $row['isConfirmed'];
        $dates[$i]['prolongation_hours'] = $row['prolongation_hours'];
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
    $arrResult = [];
    foreach($array as $pole){
        $arr = [];
        for($i = 0; $i < count($pole['dates']); $i++){
            if($pole['dates'][$i] == date("Y-m-d")){
                $arr['roomNum'] = $pole['roomNum'];
                $arr['booking_id'] = $pole['id'];
                $arr['guestName'] = $pole['guestName'];
                $arr['NOT_ARRIVED'] = false;
                $arr['BUTTON'] = array();
                $arr['BUTTON']['SHOW'] = 0;
                $arr['BUTTON']['ACTION'] = 'none';
                $arr['BUTTON_DEPOSIT'] = array();
                $arr['DATA_MODAL'] = 'modal';
                $arr['WARNING'] = '';
                $arr['DEBT'] = false;
                $arr['ICON'] = '';
                $arr['BUTTON']['HREF'] = '';
                $not_arrived = false;
                $query = $link->query("SELECT checkIn, messageSent FROM booking WHERE id = {$pole['id']}");
                $query = $query->fetch_array();
                //checkInn btn
                if($i >= 1 && $query['checkIn'] == 0){
                    $arr['WARNING'] = 'red';
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
                            $link->query("UPDATE booking SET messageSent = 1 WHERE id = {$pole['id']}");
                            }
                        }
                }
                if($query['checkIn'] == 0){
                    $arr['BUTTON']['SHOW'] = 1;
                    $arr['BUTTON']['TEXT'] = 'Подтвердить заезд';
                    $arr['BUTTON']['CLASS'] = 'btn-yellow';
                    $arr['BUTTON']['ACTION'] = 'checkIn';
                }
                //host action
                if($query['checkIn'] == 1){
                    $debtAmount = getDebt($pole['id'], $pole['amount']);
                    if($debtAmount > 0){
                        $arr['DEBT'] = $debtAmount;
                    }
                }
                switch($i) {
                    case 0:
                        $arr['ACTION'] = "заезд";
                        $arr['ICON'] = "fa-arrow-left";
                        $arr['ACTION_CLASS'] = "check-in";
                        break;
                    case count($pole['dates'])-1:
                        $arr['ACTION'] = "выезд";
                        $arr['ACTION_CLASS'] = "check-out";
                        $arr['ICON'] = "fa-arrow-right";
                        if($pole['deposit'] == 1){
                            $arr['BUTTON']['SHOW'] = 1;
                            $arr['BUTTON']['TEXT'] = 'Вернуть залог';
                           $arr['BUTTON']['CLASS'] = 'btn-yellow return-deposit';
                           $arr['BUTTON']['ACTION'] = 'return-deposit';
                        }
                        break;
                    default:
                        $arr['ACTION'] = "проживает";
                        $arr['ACTION_CLASS'] = "live-in";
                        $arr['BUTTON']['SHOW'] = 0;
                        $arr['ICON'] = "fa-bed";
                        break;
                }
                if($not_arrived){
                    $arr['ICON'] = "";
                    $arr['NOT_ARRIVED'] = 'is-late';
                    $arr['ACTION'] = "не заезд";
                    $arr['BUTTON']['SHOW'] = 1;
                    $arr['BUTTON']['HREF'] = '/admin/booking_page/cancel/'.$pole['id'];
                    $arr['BUTTON']['CLASS'] = 'not-checked-in btn-red';
                    $arr['BUTTON']['TEXT'] = 'Отменить бронь'; 
                    $arr['BUTTON']['ACTION'] = 'cancel-booking';
                    $arr['DATA_MODAL'] = '';
                }
                array_push($arrResult, $arr);
            }
        }
    }
    return $arrResult;
}
function getPrePayGuests(){
    global $link;

    $today = date("Y-m-d");
    $week =  date_format(date_modify(date_create(), '7days'), "Y-m-d");

    $select = $link->query("SELECT * FROM booking  WHERE (dateStart BETWEEN '{$today}' AND '{$week}') AND (canceled = 0) AND (isConfirmed = 0)");
    if(mysqli_num_rows($select) == 0){
        return false;
    }
    $arr = array();
    while($row = $select->fetch_assoc()) {

        $pole['booking_id'] = $row['id'];
        $pole['guestName'] = $row['guestName'];
        $pole['checkIn'] = date_format(date_create($row['dateStart']), "d.m");

        if ($row['payment'] == 'Предавторизация платежа' || $row['payment'] == 'Предоплата') {
            $pole['action_text'] = 'Предоплата';
            $pole['icon'] = 'fa-cc-visa';
            $pole['action'] = 'pre-payment';
            $pole['modal'] = 'modal';
        } else {
            $pole['action_text'] = ' Подтверждение';
            $pole['icon'] = 'fa-phone';
            $pole['action'] = 'confirm-booking';
            $pole['modal'] = '';
        }
        $arr[] = $pole;
    }
    return $arr;
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
//    $array = \models\Services::getElementList('services', '*','')
    $select = $link->query("SELECT * FROM services_list")->fetch_all(MYSQLI_ASSOC);
    return $select;
}
function getServices($id){
    global $link;
    $select = $link->query("SELECT * FROM services WHERE b_id = {$id}");
    $arrServices = [];
    while($row = $select->fetch_array()){
        if($row['name'] == 'Почасовое продление'){
            $hourStart = $link->query("SELECT PROLONGATION_HOURS_START FROM settings")->fetch_array()['PROLONGATION_HOURS_START'];
            $hours = $row['quantity'];
            $time = new DateTime($hourStart);
            $time = $time->modify("+$hours hours")->format('H:i');
            $row['quantity'] = "до $time ($hours ч.)";
        }
        else{
            if($row['quantity'] == 1){
                $row['quantity'] = "";
            }
            else{
                $row['quantity'] = "x".$row['quantity'];
            }
        }
        $price = separateThousands($row['price']);
        $arr = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'quantity' => $row['quantity'],
            'price' => $price

        );
        array_push($arrServices, $arr);
    }
    return $arrServices;
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
        header("location:auth_script.php");
    }
}

class DayBalance{
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
            $check = $link->query("SELECT * FROM payments WHERE (date >= '{$nextStart}' AND date < '{$nextEnd}') AND name = 'Остаток в кассе'");
            $balance = $this->getBalance();
            if(mysqli_num_rows($check) == 0){
                $date = date_format(date_modify(date_create($this->endDay),"+1 minute"), "Y-m-d H:i");
                $insert = $link->query("INSERT INTO `payments`( `name`, `status`, `type`, `date`, `amount`, `comment`, `whoPay`, `whoAdd`) VALUES ('Остаток в кассе','+','Наличные','{$date}',{$balance},'','','auto')");
            }
            else{
                if(isset($_GET['refresh'])) {
                    if ($check->fetch_array()['amount'] != $balance) {
                        $link->query("UPDATE payments SET amount = {$balance} WHERE (date >= '{$nextStart}' AND date < '{$nextEnd}') AND name = 'Остаток в кассе'");
                    }
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
        $query = $link->query("SELECT * FROM payments WHERE (date >='{$this->startDay}' AND date < '{$this->endDay}') AND status = '{$type}' ORDER by date");
//        $array = $query->fetch_all();
        while($row = $query->fetch_array()){
            array_push($array,$row);
        }
        return $array;
    }

    function getTotal($type){
        global $link;
        $array = [];
        $sum = $link->query("SELECT type, SUM(amount) as total FROM payments WHERE (date >='{$this->startDay}' AND date < '{$this->endDay}') AND status = '{$type}' GROUP BY type");
        while($row = $sum->fetch_array()){
            array_push($array,$row);
        }

        return $array;
    }
    function getBalance(){
        global $link;
        $total = $link->query("SELECT status, SUM(amount) as total FROM payments WHERE (date >='{$this->startDay}' AND date < '{$this->endDay}') AND type = 'Наличные' GROUP BY status");
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
    function getDateStart(){
        return date_format(date_create($this->startDay), "d.m");
    }
    function getDateEnd(){
        return date_format(date_create($this->endDay), "d.m");
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
       global $months;
       $rooms = getRoomNames();
       $from = "01.".date_format(date_create($date), "m.Y");
       $days = daysInMonth($from);
       $to = date_format(date_modify(date_create($from), "{$days} days"), "Y-m-d");
       $booking = makeDateArray($from, $days, "dateStart");
       $dates = allDatesInPeriod($from, $to);
       
       $this->dayInMonth = daysInMonth($dates[0]);
       $this->fullLoading = count($rooms) * $this->dayInMonth;
       $this->totalLoad = 0;
       $this->month = date_format(date_create($from), "m");
       $this->monthName = $months[intval($this->month) - 1];
       $this->loading_list = [];
       foreach($rooms as $key => $room) {
           $item = new Room($key, $room, $this->dayInMonth);
            array_push($this->loading_list, $item);
       }
        foreach($dates as $date) {
            foreach($rooms as $key => $room) {
                foreach($booking as $row){
                    if(intval($key) == intval($row['roomNum'])){
                        $date = date_format(date_create($date), "Y-m-d");
                        for($i = 0; $i < count($row['dates']); $i++){
                            if($date == $row['dates'][$i]){
                                if($row['checkIn'] == 1){
                                    if($i != count($row['dates']) - 1){
                                        $this->loading_list[$key-1]->bookedNights += 1;
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
    $value = number_format($int, 0, ',', ' '). " руб.";
    return $value;
}

//Фунцкия некорректна, берет только суммы всех броней, у которых заезд в данном месяце. Не учитывает должников и предавторизации.
function getBookingBalance($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $current_date = date("Y-{$month}")."-01";
    $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");
    $booking_revenue = $link->query("SELECT b_sum as book, s_sum as serv, b_sum + s_sum as total FROM 
(SELECT sum(amount) as b_sum from booking where (dateStart BETWEEN '{$current_date}' AND '{$end_of_month}') AND (canceled = 0) AND (checkIn = 1)) as book, 
(SELECT sum(price) as s_sum from services where (date BETWEEN '{$current_date}' AND '{$end_of_month}')) as serv")->fetch_assoc();
    return $booking_revenue;
}

function getServicesBalance($month){
    global $link;

    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $current_date = date("Y-{$month}")."-01";
    $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");

    $sql = "SELECT sum(price) as total from services where (date BETWEEN '{$current_date}' AND '{$end_of_month}')";
    $services = $link->query($sql)->fetch_assoc()['total'];
    return $services;
}

function getReturns($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $current_date = date("Y-{$month}")."-01";
    $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");
    $sql = "SELECT SUM(amount) as returned, type FROM payments WHERE (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '{$current_date}' AND '{$end_of_month}') AND (name = 'Возврат') GROUP BY type";
    $returned = $link->query($sql);
    $total = 0;
    $returns_array = [];
    while($row = $returned->fetch_assoc()){
        $returns_array[$row['type']] = $row['returned'];
        $total += $row['returned'];
    }
    if(!array_key_exists("Безналичный расчет", $returns_array)){
        $returns_array['Безналичный расчет'] = 0;
    }
    if(!array_key_exists("Наличные", $returns_array)){
        $returns_array['Наличные'] = 0;
    }
    $returns_array['total'] = $total;
    return $returns_array;
}
function getPaymentsBalance($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $current_date = date("Y-").$month."-01";
    $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");
    $income_revenue = $link->query("SELECT m_sum - first_payment as total FROM (SELECT SUM(amount) as m_sum from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '{$current_date}' AND '{$end_of_month}') AND (NOT name = 'Остаток в кассе') AND (NOT name = 'внесение в кассу') AND (status = '+')) total, (SELECT amount as first_payment FROM payments WHERE DATE_FORMAT(date, '%Y-%m-%d') = '{$current_date}' AND name = 'Остаток в кассе') first_p")->fetch_assoc();
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

function clearDB(){
    global $link;
    $sql = "SHOW TABLES";
    $tables = $link->query($sql);
    while($row = $tables->fetch_assoc()) {
        $arrTables[] = $row['Tables_in_welcome'];
    }
    foreach ($arrTables as $query){
        $link->query("DROP TABLE $query");
    }
}

function prolongationHourOptions($arrSettings){
    $timeEnd = new DateTime($arrSettings['PROLONGATION_HOURS_MAX']);
    $timeStart = new DateTime($arrSettings['PROLONGATION_HOURS_START']);
    $step = $arrSettings['PROLONGATION_HOURS_STEP'];
    $hours = $timeStart->diff($timeEnd)->h;
    for($i = 0; $i <= $hours; $i += $step){
        $selected = '';
        if($i == 1){
            $selected = 'selected';
        }
        $minutes = 60 * $i;
        $timeStart = new DateTime($arrSettings['PROLONGATION_HOURS_START']);
        $option = date_modify($timeStart, "+$minutes minutes")->format("H:i");
        echo "<option $selected>$option</option>";
    }
}

function selectHours($arrSettings, $choosen = '', $dateStart = ''){

    if(!$dateStart){
        $dateStart = $arrSettings['PROLONGATION_HOURS_START'];
    }
    $step = $arrSettings['PROLONGATION_HOURS_STEP'];
    $hours = 12;
    for($i = 0; $i <= $hours; $i += $step){
        $minutes = 60 * $i;
        $timeStart = new DateTime($dateStart);
        $selected = '';
        $option = date_modify($timeStart, "+$minutes minutes")->format("H:i");
        if($choosen == $option){
            $selected = 'selected';
        }
        $arrOptions[] =  "<option $selected>$option</option>";
    }
    return $arrOptions;
}
function prolongationMaxHours($choosen){
    for($i = 0; $i <=24; $i++){
        if(strlen($i) < 2){
            $hour = '0'.$i;
        }
        else{
            $hour = $i;
        }
        $hour .=":00";
        $selected = '';
        if($choosen == $hour){
            $selected = "selected";
        }
        echo "<option $selected>$hour</option>";
    }
}
function getActiveTab($obj, $tab){
    if($obj->route['controller'] == $tab){
        return 'active';
    }
}
function prolongationStep($choosen){
    $arr = array('0.5'=>'Полчаса', '1' =>'Час');
    foreach($arr as $key=>$value){
        $selected = '';
        if($choosen == $key){
            $selected = 'selected';
        }
        echo "<option value='$key' $selected>$value</option>";
    }
}
function prolongationCostType($choosen){
    global $prolongation_cost_types;
    $input = "hidden";
    $input_disabled = "disabled";
    $select_disabled = "";
    if(strlen($choosen) > 1){
        $input = "";
        $input_disabled = "";
        $select_disabled = "disabled";
    }
    echo '<select id="PROLONGATION_PRICE_OPTION" name="PROLONGATION_PRICE_OPTION" class="form-control">';
    foreach($prolongation_cost_types as $key=>$value){
        $selected = '';
        if($choosen == $key){
            $selected = "selected";
        }
        if(strlen($choosen) > 1){
            $selected = 'selected';
        }
        echo "<option $selected value='$key'>$value</option>";
    }
    echo  "</select>
            <input type='text' name='PROLONGATION_PRICE_OPTION' class='form-control $input fixed-price-input-hours' value='$choosen' placeholder='Стоимость' $input_disabled>";
    
}

function getCostsAmount($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $current_date = date("Y-").$month."-01";
    $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");
    $sql = "SELECT SUM(AMOUNT) as total FROM `costs` WHERE (DATE_FORMAT(DATE, '%Y-%m-%d') BETWEEN '{$current_date}' AND '{$end_of_month}')";
    $total = $link->query($sql)->fetch_array()['total'];
    return $total;
    
    

}
function getSourcesList($choosen = ''){
    global $sources;
    $options = '';
    foreach ($sources as $source){
        $selected = '';
        if($choosen == $source){
            $selected = "selected";
        }
        $options .= "<option>$source</option>";
    }
    return $options;
}

function getSortedCosts($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $current_date = date("Y-").$month."-01";
    $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");
    $sql = "SELECT * FROM `costs` WHERE (DATE_FORMAT(DATE, '%Y-%m-%d') BETWEEN '{$current_date}' AND '{$end_of_month}')";
    $all_costs = $link->query($sql);
    $costs_sorted = [];
    $no_cat = 'Без подкатегории';
    while($row = $all_costs->fetch_assoc()){
        if(array_key_exists($row['CATEGORY'], $costs_sorted)){
            if($row['SUB_CATEGORY'] != ''){
                if(array_key_exists($row['SUB_CATEGORY'], $costs_sorted[$row['CATEGORY']])){
                      array_push($costs_sorted[$row['CATEGORY']][$row['SUB_CATEGORY']], $row);
                }
                else{
                    $costs_sorted[$row['CATEGORY']][$row['SUB_CATEGORY']] = [];
                    array_push($costs_sorted[$row['CATEGORY']][$row['SUB_CATEGORY']], $row);
                }
            }
            else{
                if(array_key_exists($no_cat, $costs_sorted[$row['CATEGORY']])){
                        array_push($costs_sorted[$row['CATEGORY']][$no_cat], $row);
                }
                else{
                    $costs_sorted[$row['CATEGORY']][$no_cat] = [];
                    array_push($costs_sorted[$row['CATEGORY']][$no_cat], $row);
                }
            } 
        }
        else{
            $costs_sorted[$row['CATEGORY']] = [];
            if($row['SUB_CATEGORY'] != ''){
                $costs_sorted[$row['CATEGORY']][$row['SUB_CATEGORY']] = [];
                array_push($costs_sorted[$row['CATEGORY']][$row['SUB_CATEGORY']], $row);
            }
            else{
                $costs_sorted[$row['CATEGORY']][$no_cat] = [];
                array_push($costs_sorted[$row['CATEGORY']][$no_cat], $row);
            }
        }
    }
    return $costs_sorted;
}
function getGroupsCategoryTotal($month){
    global $link;
    if(strlen($month) == 1){
        $month = "0".$month;
    }
    $current_date = date("Y-").$month."-01";
    $end_of_month = date_format(date_modify(date_modify(date_create($current_date), "+1 month"), "-1 day"), "Y-m-d");
    $sql = "SELECT SUM(AMOUNT) as total, CATEGORY FROM costs WHERE (DATE_FORMAT(DATE, '%Y-%m-%d') BETWEEN '{$current_date}' AND '{$end_of_month}') GROUP BY CATEGORY";
    $query = $link->query($sql);
    $array = [];
    while($row = $query->fetch_assoc()){
        array_push($array, $row);
    }
    return $array;
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function notify($data){
    $user = $data['user'];
    $action = $data['action'];
    $ip = $data['ip'];
    $name = $data['name'];
    $action_details = $data['action_details'];
    $sql = "";
}
?>
