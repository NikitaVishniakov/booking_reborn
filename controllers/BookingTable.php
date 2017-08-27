<?php
namespace controllers;
use core\base\Model;
use models\Booking;
use models\Services;

/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 21.06.17
 * Time: 21:32
 */
class BookingTable extends \core\base\Controller
{
    /**
     * Индексный контроллер. Вызывает вид index и шаблон booking_table.php
     */
    public function indexAction(){

    }

    public function ajaxGuestListAction(){
        global $link;
        $this->layout=false;
        $select = $link->query("SELECT DISTINCT booker, id, guestPhone FROM booking WHERE booker LIKE '%{$_GET['string']}%'");
        if(mysqli_num_rows($select) > 0){
            $arr = array();
            while($row = $select->fetch_assoc()){
                $arr[] = $row;
            };
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($arr,JSON_UNESCAPED_UNICODE);
        }
    }
    /**
     * если вывзываем метод без гет парметра $_GET[AJAX] -  @return True, если номер свободен и @return array(),
     * если номер занят в выбранные даты.
     * С переданным парметро AJAX вернет просто json  с ключом status в котором будет передан результат проверки ё
     * (booked or free)
     */
    public function checkAvailabilityAction(){
        $this->layout = false;
        global $link;
        $dateStart = date_format(date_create($_GET['dateStart']), "Y-m-d");
        $dateStart1 = date_format(date_modify(date_create($dateStart), '+1 day'), "Y-m-d");
        $dateEnd1 = date_format(date_create($_GET['dateEnd']), "Y-m-d");
        $filter = isset($_GET['booking_id']) ? "AND  (NOT id = {$_GET['booking_id']})" : '';

//        $dateEnd = date_format(date_modify(date_create($dateEnd), '- 1 day'), "Y-m-d");
        $sql = "SELECT * FROM booking WHERE (roomNum = {$_GET['room']}) AND (('{$dateStart}' >= dateStart AND '{$dateStart}' < dateEnd) OR ('{$dateEnd1}' > dateStart AND '{$dateEnd1}' <= dateEnd) OR (dateStart >= '{$dateStart}' AND dateStart < '{$dateEnd1}') OR (dateEnd >= '{$dateStart1}' AND dateEnd < '{$dateEnd1}')) AND (canceled = 0) $filter";
        $control = $link->query($sql);
        if(mysqli_num_rows($control) > 0){
            $arr = array();
            if(isset($_GET['AJAX'])){
                $arr['status'] = 'booked';
                header('Content-Type: application/json');
                echo json_encode($arr);
            }
            else {
                while ($row = $control->fetch_array()) {
                    $booked['dateStart'] = $row['dateStart'];
                    $booked['dateEnd'] = $row['dateEnd'];
                    $booked['guestName'] = $row['guestName'];
                    $arr[] = $booked;
                }
                return $arr;
            }
        }
        else{
            if(isset($_GET['AJAX'])){
                $arr['status'] = 'free';
                header('Content-Type: application/json');
                echo json_encode($arr);
            }
            else{
                return false;
            }
        }
    }

    /**
     * Котроллер для добавления бронирования
     */
    public function addBookingAction(){
        $this->layout = false;
        global $link;
        unset($_POST['add_booking']);
        $booking = $_POST;
        $booking['dateStart'] = date_format(date_create($booking['dateStart']), "Y-m-d");
        $booking['dateEnd'] = date_format(date_create($booking['dateEnd']), "Y-m-d");
        $booking['guestName'] = (isset($booking['guestName']) && strlen($booking['guestName'])) ? $booking['guestName'] : $booking['booker'];
        $booking['bookingDate'] = date("Y-m-d");
        $booking['whoAdd'] = $_SESSION['id'];
        $booking['second_price_start'] = strlen($booking['second_price_start']) > 0 ? date_format(date_create($booking['second_price_start']), "Y-m-d") : '';
        $booking['breakfast'] = isset($booking['breakfast']) ? 1 : 0;
        $booking['Genious'] = isset($booking['Genious']) ? 1 : 0;
        $colomns = implode(', ', array_keys($booking));
        $values = "'".implode("', '" , $booking) ."'";
        $sql = "INSERT INTO booking ($colomns) VALUES ($values)";
        if(isRoomFree($booking['roomNum'], $booking['dateStart'], $booking['dateEnd'])){
            $query = $link->query($sql);
            if($query){
                if($booking['breakfast']){
                    $guests = $booking['guestsNum'] == '2+1' ? 3 : $booking['guestsNum'];
                    $quantity = $guests * getDaysCount($booking['dateEnd'], $booking['dateStart']);
                    $b_id = $link->insert_id;
                    $arrBreakfast = array(
                        'name' => 'Завтрак(тариф)',
                        'b_id' => $b_id,
                        'quantity' => $quantity,
                        'price' => 0,
                        'date' => $booking['bookingDate']
                    );
                    Services::save('services', $arrBreakfast);
                }
                $date = date_format(date_modify(date_create($_POST['dateStart']), '-1day'), 'd.m.Y');
                header("location:/admin/?date={$date}&period=7&submit_period=OK");
            }
            else{
                echo "ошибка при добавлении бронирования. Пожалуйста, попробуйте еще раз. В случае повторения ошибки, скиньте код ошибки в службу поддержки. <br> Код ошибки: {$link->error}<br>";
                echo $sql;
            }
        }
        else{
            echo "Невозможно добавить бронь данного номера на выбранные даты, т.к. номер частично или полностью занят во время выбранного вами периода. Проверьте таблицу и измените даты или номер";
            echo "<form method='get' action='#'><input style='display:none;' type='text' name='dateStart' value='{$_POST['dateStart']}'><input type='submit' name='back' value='К таблице'></form>";
        }
    }


    /**
     * Контроллер для подсчета при стоимости брони в модалке добавления и обновления значений связанных селектов
     * Обязательно передавать гет параметр type : rooms, guestsNum, total_price, night_price, count_price.
     */
    public  function  ajaxBookingAction(){
        global $link;
        $this->layout= false;

        if($_GET['type'] == "rooms"){
            selectRoom($_GET['category'], $_GET['chosen']);
        }

        if($_GET['type'] == "guestsNum"){
            selectGuestNum($_GET['roomNum']);
        }

        if($_GET['type'] == 'total_price'){
            $dateStart = strlen($_GET['dateStart']) ? $_GET['dateStart'] : date('d.m.Y');
            $dateEnd = strlen($_GET['dateEnd']) ? $_GET['dateEnd'] : date_format(date_modify(date_create(), '+1 day'),"d.m.Y");
            $days = getDaysCount($dateEnd, $dateStart);
            $price = $_GET['total'] / $days;
            echo $price;
        }

        if($_GET['type'] == "night_price" || $_GET['type'] == 'second_night_price') {
            $dateStart = strlen($_GET['dateStart']) ? $_GET['dateStart'] : date('d.m.Y');
            $dateEnd = strlen($_GET['dateEnd']) ? $_GET['dateEnd'] : date_format(date_modify(date_create(), '+1 day'), "d.m.Y");
            $price = $_GET['price'];
            $second_price = (isset($_GET['second_price']) && strlen($_GET['second_price'])) > 0 ? $_GET['second_price'] : 0;
            $second_price_start = (isset($_GET['second_price_start']) && strlen($_GET['second_price_start'])) > 0 ? $_GET['second_price_start'] : 0;
            if($second_price){
                $days[] = getDaysCount($second_price_start, $dateStart);
                $days[] = getDaysCount($dateEnd, $second_price_start);
                $total = $days[0]*$price + $days[1]*$second_price;

            }
            else{
                $days = getDaysCount($dateEnd, $dateStart);
                $total = $price * $days;
            }
            echo $total;
        }

        if($_GET['type'] == 'category'){
            selectCategory($_GET['category']);
        }


        if($_GET['type'] == 'count_price'){
            $dateStart = (isset($_GET['dateStart']) && strlen($_GET['dateStart'])) ? $_GET['dateStart'] : date('d.m.Y');
            $dateEnd = (isset($_GET['dateEnd']) && strlen($_GET['dateEnd'])) ? $_GET['dateEnd'] : changeDate($dateStart, 1);
            $roomCat = (isset($_GET['roomCat']) && strlen($_GET['roomCat'])) ? $_GET['roomCat'] : 1;
            $guestsNum = (isset($_GET['guestsNum']) && strlen($_GET['guestsNum'])) ? $_GET['guestsNum'] : 1;
            $breakfast = (isset($_GET['breakfast']) && strlen($_GET['breakfast'])) ? $_GET['breakfast'] : 0;
            $specialGuest = (isset($_GET['specialGuest']) && strlen($_GET['specialGuest'])) ? $_GET['specialGuest'] : 0;
            $discount = (isset($_GET['discount']) && strlen($_GET['discount'])) ? $_GET['discount'] : 0;
            $days = getDaysCount($dateEnd, $dateStart);
            $additionalBed = false;
            if ($guestsNum == '2+1'){
                $guestsNum = 2;
                $additionalBed = true;
            }

            $dateStart_db = date_format(date_create($dateStart), "Y-m-d");
            $dateEnd_db = date_format(date_create($dateEnd), "Y-m-d");

            if($additionalBed){
                $additionalBed_price = Model::getPropertyList('settings', 1, array('ADDITIONAL_BED_COST'))['ADDITIONAL_BED_COST'];
            }
            else{
                $additionalBed_price = 0;
            }

            $sql = "SELECT RATE, DATE_START, DATE_END FROM rates WHERE (('$dateStart_db' BETWEEN DATE_START AND DATE_END) OR ('$dateEnd_db' BETWEEN  DATE_START AND DATE_END)) AND (CATEGORY = $roomCat) AND (GUESTS = $guestsNum)";
            $price = $link->query($sql);

            if(mysqli_num_rows($price) > 1){
                while ($row = $price->fetch_assoc()){
                    $arrPrice[] = $row['RATE'] + $additionalBed_price;
                    $arrDates[] = array('start'=>$row['DATE_START'],'end'=> $row['DATE_END']);
                }
                $counter = 0;
                $total = 0;
                if($dateStart == date_format(date_create($arrDates[0]['end']), "d.m.Y") && $days == 1){
                    $price = $arrPrice[0];
                    goto onePrice;
                }
                foreach ($arrDates as $date){
                    if($counter == 0){
                        $date1 = $dateStart;
                        $date2 = date_format(date_modify(date_create($date['end']), '1day'), "d.m.Y");
                    }
                    else{
                        $date1 = date_format(date_create($date['start']), "d.m.Y");
                        $date2 = $dateEnd;
                    }
                    $arrDays[$counter] = getDaysCount($date2, $date1);

                    if($breakfast){
                        $breakfast_cost = 150 * (intval($guestsNum) + intval($additionalBed));
                        $arrPrice[$counter] +=$breakfast_cost;
                    }
                    if($specialGuest){
                        $arrPrice[$counter] *= 0.9;
                    }
                    if($discount){
                        $arrPrice[$counter] -= $arrPrice[$counter] * $discount/100;
                    }
                    $total += $arrDays[$counter] * $arrPrice[$counter];
                    $counter++;
                }
                $arrTotal = array('total'=>$total, 'price' => $arrPrice[0], 'price2_start'=> $date1, 'price2'=> $arrPrice[1]);
                header('Content-Type: application/json');
                echo json_encode($arrTotal);
            }
            else{
                $price = $price->fetch_assoc()['RATE'] + $additionalBed_price;
                onePrice:
                if($breakfast){
                    $breakfast_cost = 150 * (intval($guestsNum) +  + intval($additionalBed));
                    $price +=$breakfast_cost;
                }
                if($specialGuest){
                    $price *= 0.9;
                }
                if($discount){
                    $price = $price - $price * $discount/100;
                }
                $total = $price * $days;
                header('Content-Type: application/json');
                $arr = array('total' => $total, 'price' => $price);
                echo json_encode($arr);
            }
        }
    }
    public function testAction(){
        $this->layout = false;
        global $link;
        $id = $link->query("SELECT id, guestName, dateStart, dateEnd, guestsNum, bookingDate FROM booking WHERE breakfast = 1");

        while($row = $id->fetch_assoc()){
            $arrId[]= $row['id'];
            $row['guestsNum'] = getDaysCount($row['dateEnd'], $row['dateStart']) * $row['guestsNum'];
            $arrBooking[] = $row;
        }
        $haveBreakfast = $link->query("SELECT b_id FROM services WHERE name ='Завтрак(тариф)'");

        while($row_b = $haveBreakfast->fetch_assoc()){
            $b_Id[]= $row_b['b_id'];
        }
        $arrRes = array_intersect($arrId, $b_Id);

        foreach ($arrRes as $key => $value){
            unset($arrBooking[$key]);
        }
        $counter=0;
        foreach ($arrBooking as $booking){
            $sql = "INSERT INTO `services`(`b_id`, `name`, `quantity`, `price`, `date`, `whoAdd`) VALUES ({$booking['id']}, 'Завтрак(тариф)', {$booking['guestsNum']}, 0, '{$booking['bookingDate']}', 'admin')";
            $link->query($sql);
            $counter++;
        }
        echo "Добавлено $counter строк";
    }
}