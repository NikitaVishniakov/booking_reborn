<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 21:11
 */
$payment = \models\Payment::getPropertyList('payments', $this->route['id']);

require_once TEMPLATES . "/modals/modal_edit_payment.php";