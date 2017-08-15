<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 31.07.17
 * Time: 0:18
 */
$item = \models\Services::getPropertyList("services", $this->route['id']);
$listServices = \models\Services::getElementList('services_list');
$date  = $item['date'] = date_format(date_create($item['date']), "d.m.Y");
require_once TEMPLATES . "modals/modal_edit_service.php";