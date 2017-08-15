<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 22:41
 */
$VISIBILITY['payment_name'] = '';
$VISIBILITY['payment_id'] = '';
$VISIBILITY['payment_type'] = '';
$PARAMS = array(
    'ACTION' => '/admin/payments/add',
    'AMOUNT' => '',
    'STATUS' => '-',
    'WHO_PAY' => $_SESSION['id'],
    'PAYMENT_NAME' => '',
    'PAYMENT_TYPE' => 'Наличные'
);
//$value = \models\Payment::getPropertyList('payments', $this->route['id'], array('amount'))['amount'];
require_once TEMPLATES . "/modals/modal_add_cashdesk_cost.php";