<?php 
//    include("header.php");
include("connection.php");
include("funcs.php");
    authCheck();
    
    $priceChange = "auto";
    if(isset($_POST['price'])){
        if(strlen($_POST['price'] > 0)){
            $price = $_POST['price'];
            $priceChange = "changed";
        }
    else {
        $price = $_POST['auto_price'];
    }
    if(empty($_POST['guestName'])){
        $_POST['guestName'] = $_POST['booker'];
    }
}
if(isset($_GET['back'])){
    header("location:index.php?date={$_GET['dateStart']}&period=14&submit_period=OK#");
}
$genious = isEmpty('genious');
$breakfast = isEmpty('breakfast');
$dateStart = date_format(date_create($_POST['dateStart']), "Y-m-d");
$dateEnd = date_format(date_create($_POST['dateEnd']), "Y-m-d");
$roomNum = $_POST['roomNum'];
$amount = $_POST['amount'];
$guestsNum = $_POST['guestsNum'];
$guestName = $_POST['guestName'];
$booker = $_POST['booker'];
$phone = isEmpty('guestPhone');
$payment = $_POST['paymentType'];
$comment =$_POST['comment'];
$days = getDaysCount($dateEnd, $dateStart);
$total = $_POST['amount'];
$source = $_POST['source'];
//echo $roomNum."<br>".$guestsNum."<br>".$dateStart."<br>".$dateEnd."<br>".$amount."<br>".$price."<br>".$priceChange."<br>".$guestName."<br>".$days."<br>".$breakfast."<br>".$genious."<br>".$payment;
if(isRoomFree($roomNum, $dateStart, $dateEnd)){
$sql = "INSERT INTO `booking`(`roomNum`, `guestsNum`, `guestName`, `dateStart`, `dateEnd`, `guestPhone`, `amount`, `breakfast`,             `Genious`, `priceChange`, `price`, `comment`, `payment`, `whoAdd`, `booker`, `source` ) VALUES ({$roomNum}, '{$guestsNum}', '{$guestName}',                          '{$dateStart}', '{$dateEnd}', '{$phone}', {$amount}, {$breakfast}, {$genious}, '{$priceChange}',                                      '{$price}','{$comment}','{$payment}','{$_SESSION['id']}', '{$booker}', '{$source}')";
    $query = $link->query($sql);
    if($query){
        $date = date_format(date_modify(date_create($_POST['dateStart']), '-1day'), 'd.m.Y');
        header("location:index.php?date={$date}&period=7&submit_period=OK");
    }
    else{
        echo "ошибка при добавлении бронирования. Пожалуйста, попробуйте еще раз. В случае повторения ошибки, скиньте код ошибки в службу поддержки. <br> Код ошибки: {$link->error}<br>";
        echo $sql;
    }
}
else{
    echo "Невозможно добавить бронь данного номера на выбранные даты, т.к. номер частично или полностью занят во время выбранного вами периода. Проверьте таблицу и измените даты или номер <form method='get' action='#'><input style='display:none;' type='text' name='dateStart' value='{$_POST['dateStart']}'><input type='submit' name='back' value='К таблице'></form>";
}
//echo $sql;




//echo $total;
?>