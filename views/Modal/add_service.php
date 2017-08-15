<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 30.07.17
 * Time: 23:14
 */
$id = $this->route['id'];
$list = \models\Services::getElementList('services_list');

require_once TEMPLATES . "/modals/modal_add_service.php";