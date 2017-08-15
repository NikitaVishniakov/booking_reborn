<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 14.08.17
 * Time: 21:09
 */
$action = 'add';

$status_options = getUserStatusList();

require_once TEMPLATES . "/modals/modal_add_user.php";