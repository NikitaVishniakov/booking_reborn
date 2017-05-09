<?php
function inputControl($string) {
    //$string = mysqli_real_escape_string($string);
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}
    if(isset($_POST['submit-msg'])){
        $name = inputControl($_POST['name']);
        $to = "marviv74@gmail.com";
        $to1 = "vishniakovcz@gmail.com";
        $charset = "windows-1251";
        $subject = "Сообщение с сайта от $name";
        $message = inputControl($_POST['message']);
        $from = inputControl($_POST['mail']);
        $send = mail($to1,$subject,$message, "from:" . $from);
        header("location:index.html");
    }
?>