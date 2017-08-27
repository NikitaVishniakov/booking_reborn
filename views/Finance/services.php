<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 27.08.17
 * Time: 14:13
 */
use models\{Booking, Services};

$month = $_GET['month'] ?? date('m');
if(strlen($month) == 1){
    $month = '0' . $month;
}
$dateStart = '2017-' . $month . '-01';
$lastDay = daysInMonth($dateStart);
$dateEnd = '2017-' . $month . "-$lastDay";

$breakfast_price = 150;

//Завтраки включенные в стоимость брони считаем по бронированиям, а не по услугам
$filter = "(checkIn = 1) AND (breakfast = 1) AND (canceled = 0) AND ((dateStart  BETWEEN  '$dateStart' AND '$dateEnd') OR (dateEnd BETWEEN '$dateStart' AND '$dateEnd'))";
$arrBooking =Booking::getElementList('booking', array('id as b_id', 'dateStart', 'dateEnd', 'breakfast', 'guestsNum' , 'guestName'), $filter);
//Нужно учитывать, что если бронь частично находится в другом месяце, то завтраки, которые находятся вне текущего месяца мы не учитываем
//Поэтому пройдемся по полученым броням

foreach ($arrBooking as &$booking){
    if($booking['dateStart'] < $dateStart){
        $bookingDays = intval(getDaysCount($booking['dateEnd'], $booking['dateStart']));
        $notInMonth = intval(getDaysCount($dateStart, $booking['dateStart']));

        //прибавляем единицу, т.к если бронь переходит на через месяц, то завтрак в день выезда учитывается.
        $breakfastDays = $bookingDays + 1 - $notInMonth;
        $arr['id'] = $booking['b_id'];
        $arr['quantity'] = $breakfastDays * $booking['guestsNum'];
        $booking['quantity'] = $breakfastDays * $booking['guestsNum'];
        $booking['price'] = $breakfastDays * $booking['guestsNum'] * $breakfast_price;
        $booking['name'] = 'Завтрак(тариф)';

        $breakfast[] = $arr;

    }
    elseif ($booking['dateEnd'] > $dateEnd){
        $bookingDays = intval(getDaysCount($booking['dateEnd'], $booking['dateStart']));
        $notInMonth = intval(getDaysCount($booking['dateEnd'], $dateEnd));
        $breakfastDays = $bookingDays - $notInMonth;
        $arr['id'] = $booking['b_id'];
        $arr['quantity'] = $breakfastDays * $booking['guestsNum'];
        $booking['quantity'] = $breakfastDays * $booking['guestsNum'];
        $booking['price'] = $breakfastDays * $booking['guestsNum'] * $breakfast_price;
        $booking['name'] = 'Завтрак(тариф)';
        $breakfast[] = $arr;
    }
    else {
        $bookingDays = intval(getDaysCount($booking['dateEnd'], $booking['dateStart']));
        $arr['id'] = $booking['b_id'];
        $arr['quantity'] = $bookingDays * $booking['guestsNum'];
        $breakfastDays = $bookingDays;
        $booking['quantity'] = $breakfastDays * $booking['guestsNum'];
        $booking['price'] = $breakfastDays * $booking['guestsNum'] * $breakfast_price;
        $booking['name'] = 'Завтрак(тариф)';
        $breakfast[] = $arr;
    }
}

//Общее количество завтраков по бронированиям
$bookingBreakfast = array();
$bookingBreakfast['total_quantity'] = 0;
foreach ($breakfast as $value){
    $bookingBreakfast['total_quantity'] += $value['quantity'];
}
$bookingBreakfast['total_amount'] = $bookingBreakfast['total_quantity'] * $breakfast_price;
$bookingBreakfast['name'] = 'Завтрак(тариф)';
$bookingBreakfast['LIST'] = $arrBooking;


//Все остальные услуги
$filter = "(date BETWEEN '$dateStart' AND '$dateEnd') AND (NOT name = 'Завтрак(тариф)') GROUP BY name";
$services = Services::getElementList('services', array('name', 'SUM(quantity) as total_quantity', 'SUM(price) as total_amount'), $filter);
if(!$services){
    $services = array();
}
global $link;
foreach ($services as &$service){
    $filter = "(date BETWEEN '$dateStart' AND '$dateEnd') AND (name = '{$service['name']}')";
    $sql = "SELECT services.b_id, services.name, services.name, services.quantity, services.price, booking.guestName FROM services INNER JOIN booking ON services.b_id = booking.id WHERE "  . $filter;
    $service_list = $link->query($sql);
    $arr = [];
    while($row = $service_list->fetch_assoc()){
        $arr[] =  $row;
    }
    $service['LIST'] = $arr;
    if($service['name'] == "Почасовое продление"){
        $service['total_quantity'] = count($service['LIST']);
    }

}

$arrServices = array_merge(array($bookingBreakfast), $services);

require_once TEMPLATES . "/services.php";
