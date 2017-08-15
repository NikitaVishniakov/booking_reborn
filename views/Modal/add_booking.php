<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 06.08.17
 * Time: 19:20
 */
$sources = getSourcesList();
$dateStart = isset($_GET['dateStart']) ? date_format(date_create(rtrim($_GET['dateStart'], '/')),  'd.m.Y') : '';

require_once TEMPLATES . "/modals/modal_add_booking.php";