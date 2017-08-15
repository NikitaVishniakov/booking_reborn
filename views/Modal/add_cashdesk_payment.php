<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 22:41
 */
$value = '';
$action = '/admin/payments/add';
$date = rtrim($_GET['date'], '/') . " 11:01:01";
$disabled = '';
$hidden = 'hidden';
require_once TEMPLATES . "/modals/modal_add_cashdesk_payment.php";