<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 14:43
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

$totalCosts = getCostsAmount($month, $year);
$arrCosts = getGroupsCategoryTotal($month,$year);

$totalBalance = getPaymentsBalance($month, $year)['total'];
$totalServices = getServicesBalance($month, $year);

$payment_types = getBalanceByPaymentTypes($month, $year);

$equairing = 0.025;
$totalEquairing = $payment_types['cashless']*$equairing;
$totalCosts += $totalEquairing;

$arrCostsFiletred = [];
foreach ($arrCosts as $item){
    $arrCostsFiltered[$item['CATEGORY']] = separateThousands($item['total'], 'руб.');
}

$arrCostsFiltered['Эквайринг'] = separateThousands($totalEquairing, 'руб.');
$arrCostsFiltered['total'] = separateThousands($totalCosts, 'руб.');

$returns = getReturns($month);

$returnsTotal = $returns['total'];

foreach ($returns as &$value){
    $value = separateThousands($value, 'руб.');
}

$cleanRevenue = separateThousands($totalBalance - $totalCosts - $returnsTotal, 'руб.');

$arrBalance = array(
    'Совокупный доход' => array(
      'Доход по бронированиям' => separateThousands($totalBalance - $totalServices, 'руб.'),
      'Доход по доп. услугам' => separateThousands($totalServices, 'руб.'),
      'total' => separateThousands($totalBalance, 'руб.')
    ),
    'Доходы по способу оплаты' => array(
        'Безналичный расчет' => separateThousands($payment_types['cashless'], 'руб.'),
        'Наличный расчет' => separateThousands($payment_types['cash'], 'руб.'),
        'total' => ''
    ),
    'Издержки' => $arrCostsFiltered,
    'Возвраты' => $returns,
);


require_once TEMPLATES . "/incomes.php";
