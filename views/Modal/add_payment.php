<?php
use models\Booking;
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 25.07.17
 * Time: 23:43
 */
$VISIBILITY['payment_name'] = '';
$VISIBILITY['payment_type'] = '';
$PARAMS = array(
    'ACTION' => '/admin/payments/add',
    'BOOKING_ID' => $this->route['id'],
    'AMOUNT' => Booking::getDebt($this->route['id']),
    'STATUS' => '+',
    'WHO_PAY' => Booking::getGuestName($this->route['id']),
    'PAYMENT_NAME' => '',
    'PAYMENT_TYPE' => ''
);

require_once TEMPLATES . "/modals/modal_add_payment.php";