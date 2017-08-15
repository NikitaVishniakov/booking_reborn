<?php
use models\Booking;

/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 13.08.17
 * Time: 14:50
 */

$VISIBILITY['payment_name'] = '';
$VISIBILITY['payment_type'] = '';
$PARAMS = array(
    'ACTION' => '/admin/payments/add',
    'BOOKING_ID' => $this->route['id'],
    'AMOUNT' => 0,
    'STATUS' => '-',
    'WHO_PAY' => Booking::getPropertyList('booking', 'guestName',$this->route['id']),
    'PAYMENT_NAME' => 'Возврат',
    'PAYMENT_TYPE' => ''
);

require_once TEMPLATES . "modals/modal_add_return.php";