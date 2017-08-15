<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 14.08.17
 * Time: 21:24
 */

$id = $this->route['id'];
$user =  \models\User::getPropertyList('users', $id);

$action = 'edit';

$placeholder = 'оставьте пустым, если не хотите менять пароль';

$status_options = getUserStatusList($user['status']);

require_once TEMPLATES . "/modals/modal_add_user.php";