<?php
require("header.php");
$current_date = "01.".date("m.Y");
if(isset($_GET['month'])){
    $month_num = $_GET['month'];
}
else{
    if(date("d") < 11){
        $month_num = date("m") -1;
    }
    else{
        $month_num = date("m");
    }
}
//$prev_month = date_format(date_modify(date_create($current_date), "-1 month"), "d.m.Y");
//$prev_prev_month = date_format(date_modify(date_create($prev_month), "-1 month"), "d.m.Y");
//$loading_1 = new RoomLoading($current_date);
//$loading_2 = new RoomLoading($prev_month);
//$loading_3 = new RoomLoading($prev_prev_month);
$equairing = 0.025;
$month_name = getMonthName($month_num);
$booking_revenue = getBookingBalance($month_num);
$income_revenue = getPaymentsBalance($month_num);
$payment_type = getBalanceByPaymentTypes($month_num);
$booking_income = $income_revenue['total'] - $booking_revenue['serv'];
$clean_cashless = $payment_type['cashless']-$payment_type['cashless']*$equairing;
$equairing_amount = $payment_type['cashless']*$equairing;
$future_payments = getFuturePayments($month_num);
$past_payments = getPastPayments($month_num);
$booking_comission = getBookingComission($month_num);
$salary = daysInMonth($current_date)*1500;



$total_all = $income_revenue['total'] - $equairing - $booking_comission - $salary;
$total_current = $income_revenue['total'] - $equairing - $booking_comission - $salary - $future_payments - $past_payments;

?>
<div class="container-fluid users-container">
    <?php include("statistics-menu.php"); ?>
<div class="col-md-9">
<div class="col-md-10 col-md-offset-1">
    <p><h3 class="inline">Доход за </h3>
    <form class="inline" action="#" method="get" id="month_select"><select name="month"class="income_month_select"><?php selectMonth($month_num); ?></select><input type="submit" value="Подтвердить"></form></p>
    <table class="table">
<!--
            <tr>
                <td>Доход по бронированиям(ожидаемый):</td>
                <td><?php echo money($booking_revenue['book']); ?></td>
            </tr>
-->
<!--
            <tr>
                <td class="text-bold text-right">Итого ожидаемый доход:</td>
                <td><?php echo  money($booking_revenue['total']); ?></td>
            </tr>
-->
            <tr>
                <td>Доход по бронированиям:</td>
                <td><?php echo  money($booking_income); ?></td>
            </tr> 
            <tr>
                <td>Доход по доп.услугам:</td>
                <td><?php echo  money($booking_revenue['serv']); ?></td>
            </tr>   
            <tr>
                <td class="text-bold text-right">Итого доход:</td>
                <td><?php echo  money($income_revenue['total']); ?></td>
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
            <td>Оплата по безналичному расчету за вычетом эквайринга:</td>
            <td><?php echo  money($clean_cashless); ?></td>
        </tr> 
    </table>
    <h3>Платежи наличными</h3>
    <table class="table">
        <tr>
            <td>Оплата наличными:</td>
            <td><?php echo  money($payment_type['cash']); ?></td>
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

    <h3>Расходы:</h3>
    <table class="table">
         <tr>
            <td>Выплаты по зарплате: </td>
            <td><?php echo  money($salary); ?></td>
        </tr> 
        <tr>
            <td>Комиссия Booking:</td>
            <td><?php echo  money($booking_comission); ?></td>
        </tr>
        <tr>
            <td>Эквайринг:</td>
            <td><?php echo  money($equairing_amount); ?></td>
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
</div>
<?php 
require ("footer.php"); 
?>