<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 22:50
 */

$payment = \models\Payment::getPropertyList('payments', $this->route['id'], array('amount', 'id'));
$value = $payment['amount'];
$action = '/admin/payments/editPayment/' . $this->route['id'];
$date = '';
$hidden = '';
$disabled = 'disabled';
require_once TEMPLATES . "/modals/modal_add_cashdesk_payment.php";