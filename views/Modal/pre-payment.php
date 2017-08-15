<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 25.07.17
 * Time: 23:21
 */
$VISIBILITY['payment_name'] = 'hidden';
$VISIBILITY['payment_type'] = '';
$PARAMS = array(
    'ACTION' => '/admin/payments/pre_payment',
    'BOOKING_ID' => $this->route['id'],
    'AMOUNT' => Booking::getFirstNightPrice($this->route['id']),
    'STATUS' => '+',
    'WHO_PAY' => Booking::getGuestName($this->route['id']),
    'PAYMENT_NAME' => 'Предоплата',
    'PAYMENT_TYPE' => 'Безналичный расчет'
);

require_once TEMPLATES . "modals/modal_add_payment.php";