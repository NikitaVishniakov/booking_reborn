<!--
  <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css?t=<?php echo(microtime(true)); ?>">
-->
<!--    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
<?php 
    include("header.php");
//function daysInMonth($date){
//    $date = date_create($date);
//    $month = intval(date_format($date, "m"));
//    $year = intval(date_format($date, "Y"));
//    if(($year % 4 == 0 and $year % 100 != 0) or ($year % 400 == 0)){
//        $vis = 1;
//    }
//    else{
//        $vis = 0;
//    }
//    switch($month){
//    case 2:
//      $days = 28 + $vis;
//      break;
//    case 1:
//    case 3:
//    case 5:
//    case 7:
//    case 8:
//    case 10:
//    case 12:
//      $days = 31;
//      break;
//    default:
//      $days = 30;
//      break;
//    }
//    return $days;
//}


$link->query("SELECT sum(amount) from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '2017-02-01' AND '2017-02-28') AND  NOT (name = 'внесение в кассу' OR name = 'Остаток в кассе') AND (status = "+")");


//class Room {
//    function __construct($roomNum, $roomName, $full){
//        $this->roomNum = $roomNum;
//        $this->roomName = $roomName;
//        $this->bookedNights = 0;
//        $this->total = 0;
//        $this->daysMonth = $full;
//    }
//    function percents(){
//        $this->percents = round($this->bookedNights / $this->daysMonth, 3) *100;
//        return $this->percents;
//    }
//}
//class RoomLoading {
//   function __construct($date){
//       global $rooms;
//       $from = "01.".date_format(date_create($date),"m.Y");
//       $days = daysInMonth($from);
//       $to = date_format(date_modify(date_create($from), "{$days} days"), "Y-m-d");
//       $booking = makeDateArray($from, $days, "dateStart");
//       $dates = allDatesInPeriod($from, $to);
//       
//       $this->dayInMonth = daysInMonth($dates[0]);
//       $this->fullLoading = count($rooms) * $this->dayInMonth;
//       $this->totalLoad = 0;
//       $this->loading_list = [];
//       foreach($rooms as $key => $room) {
//           $key += 1;
//           $item = new Room($key, $room, $this->dayInMonth);
//            array_push($this->loading_list, $item);
//       }
//        foreach($dates as $date) {
//            foreach($rooms as $key => $room) {
//                foreach($booking as $row){
//                    if(intval($key)+1 == intval($row['roomNum'])){
//                        $date = date_format(date_create($date), "Y-m-d");
//                        for($i = 0; $i < count($row['dates']); $i++){
//                            if($date == $row['dates'][$i]){
//                                if($row['checkIn'] == 1){
//                                    if($i != count($row['dates']) - 1){
//                                        $this->loading_list[$key]->bookedNights += 1;
//                                        $this->loading_list[$key]->total += $row['amount'];
//                                        $this->totalLoad += 1;
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }
//    }
//    function percents(){
//        $this->percents = round($this->totalLoad /$this->fullLoading, 3) * 100;
//        return $this->percents;
//    }
//}


$date = date("d.m.Y");
$loading = new RoomLoading($date);
$month = date("m");
foreach($months as $key => $value){
    if(intval($month) == $key + 1){
        $current_month = $value; 
    }
}
$current_date = "01.".date("m.Y");
$prev_month = date_format(date_modify(date_create($current_date), "-1 month"), "d.m.Y");
$prev_prev_month = date_format(date_modify(date_create($prev_month), "-1 month"), "d.m.Y");
$loading_1 = new RoomLoading($current_date);
$loading_2 = new RoomLoading($prev_month);
$loading_3 = new RoomLoading($prev_prev_month);
?>
<div class="container">
<div class="col-md-8 col-md-offset-2 ">
    <p class="header text-bold">Статистика номерного фонда</p>
    <table class="table ">
        <thead>
            <tr>
                <td>Номер</td>
                <td>Кол-во занятых за  месяц ночей</td>
                <td>Процент загрузки номера</td>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php 
        foreach($loading->loading_list as $room){

            echo "<tr><td>{$room->roomName}</td><td>{$room->bookedNights}</td><td>{$room->percents()} %</td></tr>";
        }
            ?>
        </tbody>
    </table>
</div>
<?php 
    $booking_revenue = getBookingBalance($month);
//    $booking_revenue = $link->query("SELECT b_sum as book, s_sum as serv, b_sum + s_sum as total FROM (SELECT SUM(amount) as b_sum from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '2017-02-01' AND '2017-02-28') AND (NOT name = 'Остаток в кассе') AND (NOT name = 'доп. услуги') AND (NOT name = 'внесение в кассу') AND (status = '+')) as book, (SELECT SUM(amount) as s_sum from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '2017-02-01' AND '2017-02-28') AND (name = 'доп. услуги')) as serv")->fetch_array();

    $payment_types = $link->query("SELECT type, SUM(amount) as b_sum from payments where (DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '2017-02-01' AND '2017-02-28') AND (NOT name = 'Остаток в кассе') AND (status = '+') GROUP BY type")->fetch_array();
    $income_revenue = getPaymentsBalance($month);
?>
<div class="row">
<div class="col-md-8 col-md-offset-2">
    <p class="header text-bold">Доход за <?php echo $current_month; ?></p>
    <table class="table">
            <tr>
                <td>Доход по бронированиям(ожидаемый):</td>
                <td><?php echo money($booking_revenue['book']); ?></td>
            </tr>
            <tr>
                <td>Доход по доп.услугам(ожидаемый):</td>
                <td><?php echo  money($booking_revenue['serv']); ?></td>
            </tr>
            <tr>
                <td>Итого ожидаемый доход:</td>
                <td><?php echo  money($booking_revenue['total']); ?></td>
            </tr>
            <tr>
                <td>Доход по бронированиям(реальный):</td>
                <td><?php echo  money($income_revenue['book']); ?></td>
            </tr> 
            <tr>
                <td>Доход по доп.услугам (реальный):</td>
                <td><?php echo  money($income_revenue['serv']); ?></td>
            </tr>
            <tr>
                <td>Итого реальный доход(бронирования + услуги):</td>
                <td><?php echo  money($income_revenue['total']); ?></td>
            </tr>
    </table>
</div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-2">
        <p class="header text-bold">Общая загрузка номерного фонда:</p>
        <table class="table">
                <tr>
                    <td>Загрузка за январь:</td>
                    <td><?php echo $loading_3->percents(); ?> %</td>
                </tr>
                <tr>
                    <td>Загрузка за февраль:</td>
                    <td><?php echo $loading_2->percents(); ?> %</td>
                </tr>
                <tr>
                    <td>Загрузка за текущий месяц(март):</td>
                    <td><?php echo $loading_1->percents(); ?> %</td>
                </tr>

        </table>
    </div>
</div>
</div>
<script>
    prompt();
</script>

<!--//echo $to;-->
<?php
    include("footer.php");
?>
