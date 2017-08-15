<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 13.08.17
 * Time: 11:37
 */
//echo $this->route['id'];
$arrSettings = \core\base\Model::getPropertyList('settings', 1);

$booking_id = $this->route['id'];
$name =  "Почасовое продление";

$price_per_hour = ceil($_GET['price']/24);
$hours = $_GET['hours'] ?? 1;


$total_price = $hours * $price_per_hour;

require_once TEMPLATES . "modals/modal_add_prolongation.php";