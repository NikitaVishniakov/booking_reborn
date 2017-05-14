<?php 
require_once("connection.php");
include("funcs.php");
if(!isset($_SESSION['id'])){
    session_start();
}

if(isset($_POST['submit_pre_pay'])){
    $amount = $_POST['amount'];
    $type = $_POST['type'];
    $name = $link->query("SELECT guestName FROM booking WHERE id = {$_POST['id']}")->fetch_array()['guestName'];
    $insert = $link->query("INSERT INTO `payments`(`name`, `status`, `type`, `amount`, `comment`, `whoPay`,`whoAdd`, `bookingId` ) VALUES ('Предавторизация', '+', '{$type}', {$amount}, '', '{$name}', '{$_SESSION['id']}', {$_POST['id']})");
    header("location:{$_SERVER['HTTP_REFERER']}");
}
if(isset($_POST['add-category'])){
    $name = inputControl($_POST['CAT_NAME']);
    $sql = "INSERT INTO `costs_categories`(`NAME`) VALUES ('{$name}')";
    $query = $link->query($sql);
    if($query){
        header("location:{$_SERVER['HTTP_REFERER']}");
    }
    else{
        echo $sql;
    }
}

if(isset($_POST['edit-cost'])){
    $id = $_POST['ID'];
    $category_id = $_POST['cost_category'];
    $sql = "SELECT NAME FROM `costs_categories` WHERE ID = {$category_id}";
    $category = $link->query($sql)->fetch_array()['NAME'];    
    $subcategory = $_POST['cost_sub_category'];
    $unit = $_POST['costs-units'];
    $payment_type = $_POST['PAYMENT_TYPE'];
    $name = inputControl($_POST['cost_name']);
    $amount = inputControl($_POST['cost_amount']);
    if(inputControl($_POST['cost-quantity']) == 0){
        $quantity = '';
    }
    else{
        $quantity = inputControl($_POST['cost-quantity']);
    }
    $sql = "UPDATE `costs` SET `NAME`='$name',`PAYMENT_TYPE`='$payment_type', `AMOUNT`=$amount,`CATEGORY`='$category',`SUB_CATEGORY`='$subcategory',`UNIT`='$unit',`QUANTITY`='$quantity' WHERE ID = $id";
    $query = $link->query($sql);
    if($query){
        header("location:{$_SERVER['HTTP_REFERER']}");
    }
    else{
        echo $sql;
    }
}


if(isset($_POST['ADD_COST'])){
    $category_id = $_POST['cost_category'];
    $sql = "SELECT NAME FROM `costs_categories` WHERE ID = {$category_id}";
    $category = $link->query($sql)->fetch_array()['NAME'];    
    $subcategory = $_POST['cost_sub_category'];
    $unit = $_POST['costs-units'];
    $payment_type = $_POST['PAYMENT_TYPE'];
    $name = inputControl($_POST['cost_name']);
    $amount = inputControl($_POST['cost_amount']);
    if(inputControl($_POST['cost-quantity']) == 0){
        $quantity = '';
    }
    else{
        $quantity = inputControl($_POST['cost-quantity']);
    }
    $sql = "INSERT INTO `costs`(`NAME`, `PAYMENT_TYPE`, `AMOUNT`, `CATEGORY`, `SUB_CATEGORY`, `UNIT`, `QUANTITY`) VALUES ('{$name}', '{$payment_type}', {$amount}, '{$category}', '{$subcategory}', '{$unit}', '{$quantity}')";
    $query = $link->query($sql);
    if($query){
        header("location:{$_SERVER['HTTP_REFERER']}");
    }
    else{
        echo $sql;
    }
}


if(isset($_POST['add-sub-category'])){
    $name = inputControl($_POST['SUB_CAT_NAME']);
    $p_id = $_POST['cost_category_modal'];
    $sql = "INSERT INTO `costs_sub_categories`(`ID_CATEGORY`, `NAME`) VALUES ({$p_id}, '{$name}')
";
    $query = $link->query($sql);
    if($query){
        header("location:{$_SERVER['HTTP_REFERER']}");
    }
    else{
        echo $sql;
    }

}

/*ПОДТВЕРЖДЕНИЕ ЗАСЕЛЕНИЯ И ВНЕСЕНИЕ ДАННЫХ ПЛАТЕЖА*/

        if(isset($_POST['submit_checkIn'])){
            $query = $link->query("UPDATE booking SET checkIn = 1 WHERE id = {$_POST['id']}");
            $select = $link->query("SELECT * FROM booking WHERE id = {$_POST['id']}");
            $select = $select->fetch_array();
            $amount = $_POST['amount'];
            if($amount > 0){
            $insert = $link->query("INSERT INTO `payments`(`name`, `status`, `type`, `amount`, `comment`, `whoPay`,`whoAdd`, `bookingId` ) VALUES ('Проживание', '+', '{$_POST['type']}', {$amount}, '{$_POST['comment']}', '{$select['guestName']}', '{$_SESSION['id']}', {$_POST['id']})");
            }
            if(isset($_POST['deposit'])){
                $update = $link->query("UPDATE booking SET deposit = 1 WHERE id = {$_POST['id']}");
            }
            header("location:{$_SERVER['HTTP_REFERER']}");
        }



 /*РЕДАКТИРОВАНИЕ ПЛАТЕЖА ИЗ ФИНАНСОВ*/
 
if(isset($_POST['edit-payment'])){
    $query = $link->query("UPDATE payments SET name = '{$_POST['name']}', type = '{$_POST['type']}', amount = {$_POST['amount']}, comment = '{$_POST['comment']}' WHERE id = {$_POST['id']}");
    if($query){
        header("location:finance.php");
    }
}
 /*ПОДТВЕРЖДЕНИЕ ПЛАТЕЖА ИЗ ФИНАНСОВ*/


        if(isset($_POST['submit_payment'])){
            $query = $link->query("INSERT INTO payments (`name`, `status`, `type`,`date`, `amount`, `comment`, `whoAdd`) VALUES ('{$_POST['payment_type']}', '{$_POST['status']}', '{$_POST['type']}', '{$_POST['date']}', {$_POST['amount']}, '{$_POST['comment']}', '{$_SESSION['id']}')");

            header("location:{$_SERVER['HTTP_REFERER']}");
        }

 /*ПОДТВЕРЖДЕНИЕ ПЛАТЕЖА ИЗ БРОНИРОВАНИЯ*/


        if(isset($_POST['submit_payment_user'])){
            if($_POST['amount'] > 0){
            $query = $link->query("INSERT INTO payments (`name`, `status`, `type`,`date`, `amount`, `comment`, `whoAdd`, `whoPay`, `bookingId`) VALUES ('{$_POST['payment_type']}', '{$_POST['status']}', '{$_POST['type']}', '{$_POST['date']}', {$_POST['amount']}, '{$_POST['comment']}', '{$_SESSION['id']}', '{$_POST['guestName']}', {$_POST['id']})");
            }
            if($_POST['amount'] < 0){
                $amount = preg_replace("/[^0-9]/", '', $_POST['amount']);
//                echo $amount
                $query = $link->query("INSERT INTO payments (`name`, `status`, `type`,`date`, `amount`, `comment`, `whoAdd`, `whoPay`, `bookingId`) VALUES ('Возврат', '-', '{$_POST['type']}', '{$_POST['date']}', {$amount}, '{$_POST['comment']}', '{$_SESSION['id']}', '{$_POST['guestName']}', {$_POST['id']})");
            }
            if($query){
                header("location:{$_SERVER['HTTP_REFERER']}");
            }
            else{
                echo "INSERT INTO payments (`name`, `status`, `type`,`date`, `amount`, `comment`, `whoAdd`, `whoPay`, `bookingId`) VALUES ('{$_POST['payment_type']}', '{$_POST['status']}', '{$_POST['type']}', '{$_POST['date']}', {$_POST['amount']}, '{$_POST['comment']}', '{$_SESSION['id']}', '{$_POST['guestName']}', {$_POST['id']})";
            }
        }

/*ДОБАВЛЕНИЕ ПОЧАСОВОГО ПРОДЛЕНИЯ*/

        if(isset($_POST['submit_prolongation_hours'])){
            $amount = $_POST['prolongation_cost'];
            $hours = $_POST['input-hours'];
            $insert = $link->query("INSERT INTO services (`b_id`, `name`, `quantity`, `price`) VALUES ({$_POST['bookingId']},'Почасовое продление', $hours, {$amount})");
            if($insert){
                header("location:{$_SERVER['HTTP_REFERER']}");
            }
            else{
                echo "INSERT INTO services (`b_id`, `name`, `quantity`, `price`) VALUES ({$_POST['bookingId']},'Почасовое продление', 1, {$amount})";
            }
        }
 /*ДОБАВЛЕНИЕ УСЛУГИ*/

        if(isset($_POST['add_service'])){
            $select = $link->query("SELECT * FROM services_list WHERE id = {$_POST['service']}")->fetch_array();
            $amonut = intval($_POST['quantity']) * intval($select['price']);
            $insert = $link->query("INSERT INTO services (`b_id`, `name`, `quantity`, `price`) VALUES ({$_POST['id']},'{$select['name']}', {$_POST['quantity']}, {$amonut})");
            if($insert){
                header("location:{$_SERVER['HTTP_REFERER']}");
            }
            else{
                echo "INSERT INTO services (`b_id`, `name`, `quantity`, `price`) VALUES ({$_POST['id']},'{$select['name']}', {$_POST['quantity']}, {$amonut})";
            }
        }
 /*Редактирование информации брони*/
        if(isset($_POST['submit_user_edit'])){
            $breakfast = getCheckbox($_POST['breakfast']);
            $dateStart = date_format(date_create($_POST['dateStart']), "Y-m-d");
            $dateEnd = date_format(date_create($_POST['dateEnd']), "Y-m-d");
            $update = $link->query("UPDATE booking SET booker='{$_POST['booker']}', dateStart = '{$dateStart}', dateEnd = '{$dateEnd}', roomNum={$_POST['roomNum']}, guestsNum={$_POST['guestsNum']}, breakfast = {$breakfast}, guestName='{$_POST['guestName']}', guestPhone='{$_POST['phoneNum']}', source = '{$_POST['source']}', payment = '{$_POST['payment']}' WHERE id={$_POST['bookingId']}");
            if($update){
                header("location:{$_SERVER['HTTP_REFERER']}");
            }
            else {
                
                 echo "UPDATE booking SET booker='{$_POST['booker']}', dateStart = '{$dateStart}', dateEnd = '{$dateEnd}', roomNum={$_POST['roomNum']}, guestsNum={$_POST['guestsNum']}, breakfast ={$breakfast}, guestName='{$_POST['guestName']}', guestPhone='{$_POST['phoneNum']}' WHERE id={$_POST['bookingId']}  <br>".mysqli_connect_error();
            }
        }
 /*РЕДАКТИРОВАНИЕ СУММЫ БРОНИ*/
    if(isset($_POST['submit-amount'])){
        $update = $link->query("UPDATE booking SET amount = {$_POST['amount']} WHERE id={$_POST['id']}");
        if($update){
                header("location:{$_SERVER['HTTP_REFERER']}");
            }
            else {
                echo "UPDATE booking SET amount = {$_POST['amount']} WHERE id={$_POST['id']}";
            }
    }


/*РЕДАКТИРОВАНИЕ КОММЕНТАРИЯ*/

        if(isset($_POST['submit_comment'])){
            $update = $link->query("UPDATE booking SET comment = '{$_POST['comment']}' WHERE id={$_POST['id']}");
            if($update){
                header("location:{$_SERVER['HTTP_REFERER']}");
            }
            else {
                echo "UPDATE booking SET comment = '{$_POST['comment']}' WHERE id={$_POST['id']}";
            }
        }

/*БЛОК РАБОТЫ С АЯКС*/

    if(isset($_GET['action'])){
        
if($_GET['action'] == 'hours-prolongation-modal'){
    require("modals/modal-prolongation-hours.php");
}
if($_GET['action'] == 'modal-prolongation-options'){
    require('modals/modal_prolongation_options.php');
}
        
if($_GET['action'] == 'get_subcategories'){
    selectCostSubCategories($_GET['parent_id']);
}
if($_GET['action'] == 'showCostItem'){
    $id = $_GET['id'];
    include("modals/modal-show-cost.php");
}
if($_GET['action'] == 'delete-cost'){
    $sql = "DELETE FROM `costs` WHERE ID = {$_GET['id']}";
    $delete = $link->query($sql);
}
        
/* РАССЧЕТ СТОИМОСТИ ПОЧАСОВОГО ПРОДЛЕНИЯ*/
        
if($_GET['action'] == 'prolongation-count-cost'){
    $id = $_GET['id'];
    $select = $link->query("SELECT * FROM booking WHERE id = $id");
    $values = $link->query("SELECT PROLONGATION_HOURS_START, PROLONGATION_PRICE_OPTION FROM settings")->fetch_array();
    $profile = $select->fetch_array();
    $nights = getDaysCount($profile['dateStart'], $profile['dateEnd']);
    $time1 = strtotime($values['PROLONGATION_HOURS_START']);
    $time2 = strtotime($_GET['hours']);
    $difference = round(abs($time2 - $time1) / 3600,2);
    if($values['PROLONGATION_PRICE_OPTION'] == 1){
        $price_per_night = $profile['amount'] / $nights;
        $price_per_hour = $price_per_night / 24;
    }
    elseif($values['PROLONGATION_PRICE_OPTION'] == 2){
        $price_per_night = $profile['amount'] / $nights;
        $price_per_hour = $price_per_night / 24;
    }
    else{
        $price_per_hour = $values['PROLONGATION_PRICE_OPTION'];
    }
    echo round($price_per_hour*$difference).",".$difference;
}
        
 /*УДАЛЕНИЕ ПЛАТЕЖА ИЗ ФИНАНСОВ*/

if($_GET['action'] == "delete-payment"){
    $id = $_GET['id'];
    $delete = $link->query("DELETE FROM payments WHERE id = $id");
    if($delete){
        echo "Платёж удален";
    }
}

/*ПРОСМОТР ПЛАТЕЖА*/
        if($_GET['action'] == "showPayment"){
            $id = $_GET['id'];
            require("modals/modal_payment_detail_view.php");
        }
        
/*УДАЛЕНИЕ УСЛУГИ ИЗ СПИСКА В ЛК*/
        if($_GET['action'] == "deleteService"){
            $delete = $link->query("DELETE FROM services WHERE id = {$_GET['id']}");
        }

 
        /*ВОЗВРАТ ЗАЛОГА*/
        if($_GET['action'] == "returnDeposit"){
            $link->query("UPDATE booking SET deposit = 0 WHERE id = {$_GET['id']}");
        }
 /*ВОЗВРАТ ЗАЛОГА ОТ ВОРОТ*/
        if($_GET['action'] == "returnGatesDeposit"){
            $link->query("UPDATE booking SET depositGates = 0 WHERE id = {$_GET['id']}");
        }
/*ВНЕСЕНИЕ ЗАЛОГА*/ 
        if($_GET['action'] == "getDeposit"){
            $link->query("UPDATE booking SET deposit = 1 WHERE id = {$_GET['id']}");
        }
        
/*ВНЕСЕНИЕ ЗАЛОГА ОТ ВОРОТ*/ 
           if($_GET['action'] == "getGatesDeposit"){
            $link->query("UPDATE booking SET depositGates = 1 WHERE id = {$_GET['id']}");
        }
        $modal = "";
/*ВНЕСЕНИЕ ДАННЫХ ПЛАТЕЖА(СПИСАНИЕ*/
        if($_GET['action'] == "plus"){
            $header = "Добавить поступление";
            $options_array = [];
            $status = "+";
            $date = $_GET['date'];
            $options = $link->query("SELECT name FROM payment_types WHERE type = '+'");
            while($row = $options->fetch_array()){
                array_push($options_array, $row['name']);
            }
            require("modals/modal_add_payment.php");
        }
        if($_GET['action'] == "minus"){
            $header = "Добавить списание";
            $options_array = [];
            $date = $_GET['date'];
            $options = $link->query("SELECT name FROM payment_types WHERE type = '-'");
            $status = "-";
            while($row = $options->fetch_array()){
                array_push($options_array, $row['name']);
            }
            require("modals/modal_add_payment.php");
        }
        
/*ОТМЕНА ПОДВЕРЖДЕНИЯ ЗАЕЗДА ГОСТЯ*/

        if($_GET['action'] == "cancel_checkIn"){
            $update = $link->query("UPDATE booking SET checkIn = 0 WHERE id = {$_GET['id']}");
            $delete = $link->query("DELETE FROM payments WHERE bookingId = {$_GET['id']}");
            $query = $link->query("SELECT * FROM booking WHERE id = {$_GET['id']}");
        }
/*УДАЛЕНИЕ БРОНИ ИЗ БАЗЫ ДАННЫХ*/
        
        if($_GET['action'] == 'delete'){
            $query = $link->query("DELETE FROM `booking` WHERE id = {$_GET['id']}");
            $header = "Удаление брони";
            $modal = "small";
            if($link->affected_rows > 0){
                $text = "Запись удалена";
            }
            else {
                $text = "Упс, что то пошло не так. Запись не была удалена";
                if($link->affected_rows == -1){
                    $text = $text."<br>ошибка Mysql: {$link->error}";
                }
                else {
                    $text = $text."<br>(возможно, она была удалена ранее)";
                }
            }
            
        } 
        
/*ОТМЕНА БРОНИ*/
        
        if($_GET['action'] == 'cancel'){
            $query = $link->query("UPDATE `booking` SET `canceled`= 1  WHERE id = {$_GET['id']}");
            $header = "Отмена брони";
            $modal = "small";
            if($link->affected_rows > 0){
                $text = "Бронь отменена";
            }
            else{
                $text = "Упс, что то пошло не так. Бронирование не было отменено";
                if($link->affected_rows == -1){
                    $text = $text."<br>ошибка Mysql: {$link->error}";
                }
                else {
                    $text = $text."<br>(возможно, вы попытались отменить уже отмененное бронирование)";
                }
            }
        }
       
/* РЕДАКТИРОВАНИЕ БРОНИ */
        
        if($_GET['action'] == 'edit'){
            $query = $link->query("SELECT * FROM `booking` WHERE id = {$_GET['id']}");
            $row = $query->fetch_array();
            include("modals/modal_add_booking.php");
        }
        
/*ВЫХОД*/
        
        if($_GET['action'] == "exit"){
            session_destroy();
            header("location:index.php");
        }

/*ПОИСК БРОНИРОВАНИЯ*/
            
        if($_GET['action'] == "search"){
            $modal = "modal_booked";
            $query = $link->query("SELECT * FROM booking WHERE guestName LIKE '%{$_GET['name']}%'");
            if(mysqli_num_rows($query) > 0){
                if(mysqli_num_rows($query) == 1){
                    $row = $query->fetch_array();
                    $_GET['id'] = $row['id'];
                    include($modal.".php");
//                    header("location:{$modal}.php?id={$row['id']}"); 
                }
                else{
                    include("search_booking_table.php");
                }
            }
            else {
                
            }
        }
            
/* ВЫЗОВ ОКНА ВНЕСЕНИЯ ПРЕДОПЛАТЫ */
    if($_GET['action'] == 'pre_pay'){
          $booking = $link->query("SELECT * FROM booking WHERE id = {$_GET['id']}")->fetch_array();
          $days = getDaysCount($booking['dateEnd'], $booking['dateStart']);
          $pre_pay = $booking['amount'] / $days;
          include("modals/modal_add_prepayment.php");
    }
        
/*ВЫЗОВ ОКНА ПОДТВЕРЖДЕНИЯ ЗАСЕЛЕНИЯ*/
            
        if($_GET['action'] == 'checkIn'){
            $query = $link->query("SELECT id, guestName, amount FROM booking WHERE id = {$_GET['id']}");
            $services = $link->query("SELECT SUM(price) as total FROM services WHERE b_id = {$_GET['id']}")->fetch_array();
            $query = $query->fetch_array();
            $total = getDebt($_GET['id'], $query['amount']);
            $header ="Подтверждение заезда";
            include("modals/modal_confirm_checkIn.php");
//            $query = $link->query("UPDATE booking SET checkIn = 1 WHERE id = {$_GET['id']}");
//            header("location:{$_SERVER['HTTP_REFERER']}");
            }
        if(isset($_GET['showBooking'])){
            header("location:booking_page.php?id={$_GET['id']}");
        }
/*ДОБАВИТЬ ПОЛЬЗОВАТЕЛЯ*/
        if($_GET['action'] == 'addUser'){
            $login = inputControl($_POST['login']);
            if(inputControl($_POST['password']) == inputControl($_POST['password_repeat'])){
                $password = passHash(inputControl($_POST['password']));
            }
            else {
                $error = "Пароли не совпадают";
            }
            $name = inputControl($_POST['name']);
            global $link; 
            $link->query("INSERT INTO `users`(`login`, `password`, `name`) VALUES ('{$login}','{$password}', '{$name}')");
            if($link->affected_rows == -1){
                    echo "<br>ошибка Mysql: {$link->error}";
                }
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
if($modal == "small"){
    ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $header; ?></h4>
            </div>
            <div class="modal-body">
                  <h2 class="text-center"><?php echo $text; ?></h2>
            </div>
        </div>
    </div>
<script>
      $('.close').click(function(){
                $('.layout').addClass('hidden');
                $('.modal-small').addClass('hidden');
            });
</script>
<?php
    }
}
?>


