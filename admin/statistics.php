<?php 
require_once("header.php");
$current_date = "01.".date("m.Y");
if(isset($_GET['month'])){
    $month_num = $_GET['month'];
}
else{
    if(date("d") < 11){
        $month_num = date("m") - 1;
    }
    else{
        $month_num = date("m");
    }
}
$equairing = 0.025;
$month_name = getMonthName($month_num);
$costs_total = getCostsAmoun($month_num);
$booking_revenue = getBookingBalance($month_num);
$income_revenue = getPaymentsBalance($month_num);
$payment_type = getBalanceByPaymentTypes($month_num);
$booking_income = $income_revenue['total'] - $booking_revenue['serv'];
$equairing_amount = $payment_type['cashless']*$equairing;
$future_payments = getFuturePayments($month_num);
$past_payments = getPastPayments($month_num);
$booking_comission = getBookingComission($month_num);
$salary = daysInMonth($current_date)*1500;
$returns_all = getReturns($month_num);
$returns = $returns_all['total'];
$returns_cash = $returns_all['Наличные'];
$returns_cashless = $returns_all['Безналичный расчет'];
$costs_list = getGroupsCategoryTotal($month_num);
$clean_cash = $payment_type['cash'] - $returns_cash;
$clean_cashless = $payment_type['cashless']-$payment_type['cashless']*$equairing - $returns_cashless;

$total_all = $clean_cash + $clean_cashless - $costs_total;
$total_current = $clean_cash + $clean_cashless - $future_payments - $past_payments - $costs_total;
?>
<div class="container-fluid users-container">
    <?php include("components/statistics-menu.php"); ?>
<div class="col-md-9">
<div class="col-md-10 col-md-offset-1">
    <h3 class="inline">Доход за </h3>
    <form class="inline" action="#" method="get" id="month_select">
        <select name="month"class="income_month_select">
        <?php selectMonth($month_num); ?>
        </select><input type="submit" value="Подтвердить"></form>
    <table class="table">
            <tr>
                <td>Доход по бронированиям:</td>
                <td><?php echo  money($booking_income); ?></td>
            </tr> 
            <tr>
                <td>Доход по доп.услугам:</td>
                <td><?php echo  money($booking_revenue['serv']); ?></td>
            </tr> 
            <tr>
                <td>Возвраты:</td>
                <td><?php echo  money($returns); ?></td>
            </tr>   
            <tr>
                <td class="text-bold text-right">Итого доход:</td>
                <td><?php echo  money($income_revenue['total'] - $returns); ?></td>
            </tr>
    </table>
    <h3>Безналичный расчет</h3>
    <table class="table">
        <tr>
            <td>Оплата по безналичному расчету:</td>
            <td><?php echo  money($payment_type['cashless']); ?></td>
        </tr> 
        <tr>
            <td>Эквайринг:</td>
            <td><?php echo  money($equairing_amount); ?></td>
        </tr>       
        <tr>
            <td>Возвраты по безналичному расчету:</td>
            <td><?php echo  money($returns_cashless); ?></td>
        </tr> 
        <tr class="text-bold">
            <td>Безналичный расчет за вычетом эквайринга и возвратов:</td>
            <td><?php echo  money($clean_cashless); ?></td>
        </tr> 
    </table>
    <h3>Платежи наличными</h3>
    <table class="table">
        <tr>
            <td>Оплата наличными:</td>
            <td><?php echo  money($payment_type['cash']); ?></td>
        </tr>
        <tr>
            <td>Возвраты:</td>
            <td><?php echo  money($returns_cash); ?></td>
        </tr>         
        <tr class="text-bold">
            <td>Наличность за вычетом возвратов:</td>
            <td><?php echo  money($clean_cash); ?></td>
        </tr> 
    </table>
    <h3>Издержки: </h3>
    <table class="table">
        <?php 
            foreach($costs_list as $row){
                $cost_amount = money($row['total']);
                echo "<tr><td>{$row['CATEGORY']}</td><td>$cost_amount</td></tr>";
            }
        ?>
        <tr class="text-bold">
            <td>Всего издержек:</td>
            <td><?php echo  money($costs_total); ?></td>
        </tr>
    </table>
    <h3>Включенные в доход за <?php echo $month_name; ?> платежи других периодов</h3>
    <table class="table">
        <tr>
            <td>Платежи будущих периодов:</td>
            <td><?php echo  money($future_payments); ?></td>
        </tr> 
        <tr>
            <td>Платежи прошлых периодов:</td>
            <td><?php echo  money($past_payments); ?></td>
        </tr> 
    </table>
    <h3>Прибыль:</h3>
    <table class="table">
         <tr>
            <td>Прибыль с учетом доходов иных периодов:</td>
            <td><?php echo  money($total_all); ?></td>
        </tr> 
        <tr>
            <td>Прибыль только за текущий месяц:</td>
            <td><?php echo  money($total_current); ?></td>
        </tr>
    </table>
    
    </div>
</div>
<?php 
require ("footer.php"); 
?>