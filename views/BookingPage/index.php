<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 16.07.17
 * Time: 0:50
 */

$arrResult['dateStart'] = date_format(date_create($arrResult['dateStart']), "d.m.Y");
$arrResult['dateEnd'] = date_format(date_create($arrResult['dateEnd']), "d.m.Y");
$arrResult['bookingDate'] = date_format(date_create($arrResult['bookingDate']), "d.m.Y");
$arrResult['nights'] = getDaysCount($arrResult['dateStart'], $arrResult['dateEnd']);
$arrResult['booker'] =  strlen($arrResult['booker']) > 0 ? $arrResult['booker'] : $arrResult['guestName'];
$arrResult['guestName'] =  strlen($arrResult['guestName']) > 0 ? $arrResult['guestName'] : $arrResult['booker'];
$arrPayment['has_payed'] = getUserPayments($arrResult['id']);

$returns_filter = "bookingId = " . $arrResult['id'] . " AND name = 'Возврат'";
$returns  = \models\Payment::getElementList('payments', array('amount'), $returns_filter);

$arrPayment['returns'] = 0;
if($returns){
    foreach ($returns as $value){
        $arrPayment['returns'] += $value['amount'];
    }
}

$arrPayment['amount_to_pay'] = separateThousands(getDebt($arrResult['id'], $arrResult['amount']));
$arrPayment['amount'] = separateThousands($arrResult['amount']);
$arrPayment['servicesAmount'] = separateThousands(getServicesAmount($arrResult['id']));
$arrPayment['totalPrice'] =  separateThousands(intval($arrResult['amount']) + intval($arrPayment['servicesAmount']));
$arrPayment['price'] = separateThousands($arrResult['price']);
$arrPayment['second_price'] = separateThousands($arrResult['second_price']);
$arrPayment['two_prices'] = $arrResult['second_price'] ? 'Y' : 'N';
$arrPayment['debt_class'] = $arrPayment['amount_to_pay'] > 0 ? 'red' : 'green';

$controllers['checkIn'] = $arrResult['checkIn'] ? "" : "hidden";

$services = getServices($arrResult['id']);

$gatesDeposit = $arrResult['depositGates'];

$comment = $arrResult['comment'];

$arrResult['CAN_BE_CANCELED'] = \models\Booking::getPaymentsTotal($arrResult['id']);

if($arrResult['deposit']){
    $deposits['key']['text'] = "ключ";
    $deposits['key']['btn_text'] = "Залог внесен";
    $deposits['key']['action'] = "returnDeposit";
    $deposits['key']['btn'] = "btn-green";
}
else{
    $deposits['key']['text'] = "ключ";
    $deposits['key']['btn_text'] = "Залог не внесен";
    $deposits['key']['action'] = "getDeposit";
    $deposits['key']['btn'] = "btn-yellow";
}


if($arrResult['depositGates']){
    $deposits['gates']['text'] = "ключ от ворот";
    $deposits['gates']['btn_text'] = "Залог внесен";
    $deposits['gates']['action'] = "returnGatesDeposit";
    $deposits['gates']['btn'] = "btn-green";
}
else{
    $deposits['gates']['text'] = "ключ от ворот";
    $deposits['gates']['btn_text'] = "Залог не внесен";
    $deposits['gates']['action'] = "getGatesDeposit";
    $deposits['gates']['btn'] = "btn-yellow";
}
require_once TEMPLATES . "/booking_page.php";