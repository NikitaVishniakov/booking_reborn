
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
        <tr>
            <td>Возвраты:</td>
            <td><?php echo  money($returns); ?></td>
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
<?php 
require ("footer.php"); 
?>