<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 10.07.17
 * Time: 21:35
 */
?>
<?php
$periods = [7 => 'Неделя', 14 => 'Две недели', 30 =>'Месяц'];
$date = date("d.m.Y");
$period = 7;
//exact date
if(isset($_GET['submit_period'])) {
    $date = $_GET['date'];
    $period = $_GET['period'];
}
$dates = dataCount($date, $period);
$booking = makeDateArray($date, $period, "dateStart");
$arrRooms =  divRooms();
$arrBookings = bookingContainerFill($dates, $booking);
$arrDates =  divDates($dates);
$arrToday = todayInfo();
$arrNotConfirmed = getPrePayGuests();
require_once TEMPLATES . "/booking_table.php";