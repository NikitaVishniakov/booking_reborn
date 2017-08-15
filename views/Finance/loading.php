<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 14:49
 */
$month = date("d.n.Y");
for($i = 0; $i < 6; $i++){
    $month_num[] = date_format(date_modify(date_create($month), "-$i month"), "d.m.Y");
}
foreach ($month_num as $month){
    $month_loading[] = new RoomLoading($month);
}
foreach ($month_loading as $loading){
    $formated_loading[$loading->monthName] = $loading->percents();
}
require_once TEMPLATES . "/loading.php";
