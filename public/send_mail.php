<?php
if(isset($_POST['submit-msg'])){
    $name = inputControl($_POST['name']);
    $to = "marviv74@gmail.com";
    $to1 = "vishniakovcz@gmail.com";
    $to3 = "hotel-welcome@yandex.ru";
    $charset = "windows-1251";
    $subject = "Сообщение с сайта от $name";
    $message = inputControl($_POST['message']);
    $from = inputControl($_POST['mail']);
    $send = mail($to1,$subject,$message, "from:" . $from);
    $send = mail($to,$subject,$message, "from:" . $from);
    $send = mail($to3,$subject,$message, "from:" . $from);
    $_SESSION['msg-send'] = 'Y';
    header('location:'.$_SERVER['HTTP_REFERER']);
}
?>