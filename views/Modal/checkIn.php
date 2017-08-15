<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 25.07.17
 * Time: 21:02
 */
$VISIBILITY['payment_name'] = 'hidden';
$VISIBILITY['payment_type'] = '';
$PARAMS = array(
    'ACTION' => '/admin/payments/checkIn',
    'BOOKING_ID' => $this->route['id'],
    'AMOUNT' => Booking::getDebt($this->route['id']),
    'STATUS' => '+',
    'WHO_PAY' => Booking::getGuestName($this->route['id']),
    'PAYMENT_NAME' => 'Проживание',
    'PAYMENT_TYPE' => ''
);

require_once TEMPLATES . "/modals/modal_add_payment.php";