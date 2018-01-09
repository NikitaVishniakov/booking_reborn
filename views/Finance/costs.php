<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 14:48
 */
$month = date("m");
$year = date("Y");
$arrYears = array(2016,2017,2018);
if(isset($_GET['month'])){
//    if(is_numeric($_GET['month']) && 0 > $_GET['month'] && $_GET['month'] <= 12){
        $month = $_GET['month'];
//    }
}
if((isset($_GET['year']))){
    $year = $_GET['year'];
}
?>

<?php
$totals = [];
$intTotal = 0;
$totalCostsAmount = separateThousands(getCostsAmount($month, $year), 'руб.');
$costs = getSortedCosts($month, $year);
if($costs) {
    foreach ($costs as $cat_name => $category) {
        $totals[$cat_name]['TOTAL'] = 0;
        foreach ($category as $subcat_name => $item) {
            if (is_array($item)) {
                $totals[$cat_name]['SUBCATS'][$subcat_name] = 0;
                foreach ($item as $row) {
                    $totals[$cat_name]['SUBCATS'][$subcat_name] += $row['AMOUNT'];
                }
                $totals[$cat_name]['TOTAL'] += $totals[$cat_name]['SUBCATS'][$subcat_name];
            }
        }
        $intTotal += $totals[$cat_name]['TOTAL'];
    }
}
require_once TEMPLATES . "/costs.php";
