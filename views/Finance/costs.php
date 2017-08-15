<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 14:48
 */
$month = date("m");
if(isset($_GET['month'])){
//    if(is_numeric($_GET['month']) && 0 > $_GET['month'] && $_GET['month'] <= 12){
        $month = $_GET['month'];
//    }
}
$totals = [];
$intTotal = 0;
$totalCostsAmount = separateThousands(getCostsAmount($month), 'руб.');
$costs = getSortedCosts($month);
if($costs) {
    foreach ($costs as $cat_name => $category) {
        $totals[$cat_name] = 0;
        foreach ($category as $subcat_name => $item) {
            if (is_array($item)) {
                $totals[$subcat_name] = 0;
                foreach ($item as $row) {
                    $totals[$subcat_name] += $row['AMOUNT'];
                }
                $totals[$cat_name] += $totals[$subcat_name];
            }
        }
        $intTotal += $totals[$cat_name];
    }
}

require_once TEMPLATES . "/costs.php";
