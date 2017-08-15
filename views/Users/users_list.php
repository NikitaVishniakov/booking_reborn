<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 05.08.17
 * Time: 23:04
 */
$arrUsers = models\User::getElementList('users');

require_once TEMPLATES . "/users_list.php";