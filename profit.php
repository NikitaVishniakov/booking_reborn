<?php
require("header.php");
?>
<div class="container-fluid users-container">
    <?php include("statistics-menu.php"); ?>
    <div class="col-md-9 main-body">
        <?php 
    $booking_revenue = $link->query("SELECT b_sum as book, s_sum as serv, b_sum + s_sum as total FROM 
(SELECT sum(amount) as b_sum from booking where (dateStart BETWEEN '2017-02-01' AND '2017-02-28') AND (canceled = 0) AND (checkIn = 1)) as book, 
(SELECT sum(price) as s_sum from services where (date BETWEEN '2017-02-01' AND '2017-02-28')) as serv")->fetch_array();
    $real_income = $link->query("SELECT b_sum as book, s_sum as serv, b_sum + s_sum as total FROM (SELECT SUM(amount) as b_sum from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '2017-02-01' AND '2017-02-28') AND (NOT name = 'Остаток в кассе') AND (NOT name = 'доп. услуги') AND (NOT name = 'внесение в кассу') AND (status = '+')) as book, (SELECT SUM(amount) as s_sum from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '2017-02-01' AND '2017-02-28') AND (name = 'доп. услуги')) as serv")->fetch_array();
    $payment_types = $link->query("SELECT type,SUM(amount) as b_sum from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '2017-02-01' AND '2017-02-28') AND (NOT name = 'Остаток в кассе') AND (status = '+') GROUP BY type")->fetch_array();
?>
<div class="col-md-10 col-md-offset-1">
    <p class="header text-bold">Доход:</p>
    <table class="table">
            <tr>
                <td>Доход по бронированиям(ожидаемый):</td>
                <td><?php echo number_format($booking_revenue['book'], 2, ',', ' '); ?> руб.</td>
            </tr>
            <tr>
                <td>Доход по доп.услугам(ожидаемый):</td>
                <td><?php echo number_format($booking_revenue['serv'], 2, ',', ' '); ?> руб.</td>
            </tr>
            <tr>
                <td>Итого ожидаемый доход:</td>
                <td><?php echo number_format($booking_revenue['total'], 2, ',', ' '); ?> руб.</td>
            </tr>
            <tr>
                <td>Доход по бронированиям(реальный):</td>
                <td><?php echo number_format($real_income['book'], 2, ',', ' '); ?> руб.</td>
            </tr> 
            <tr>
                <td>Доход по доп.услугам (реальный):</td>
                <td><?php echo number_format($real_income['serv'], 2, ',', ' '); ?> руб.</td>
            </tr>
            <tr>
                <td>Итого реальный доход(бронирования + услуги):</td>
                <td><?php echo number_format($real_income['total'], 2, ',', ' '); ?> руб.</td>
            </tr>
    </table>
    <p></p>
    <p></p>
</div>
    </div>
</div>
<?php 
require ("footer.php"); 
?>