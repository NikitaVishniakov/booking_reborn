<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 01.08.17
 * Time: 14:43
 */
$month = date("m");
if(isset($_GET['month'])){
//    if(is_numeric($_GET['month']) && 0 > $_GET['month'] && $_GET['month'] <= 12){
    $month = $_GET['month'];
//    }
}

$totalCosts = getCostsAmount($month);
$arrCosts = getGroupsCategoryTotal($month);

$totalBalance = getPaymentsBalance($month)['total'];
$totalServices = getServicesBalance($month);

$payment_types = getBalanceByPaymentTypes($month);

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
