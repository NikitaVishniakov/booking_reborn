<form method="post" action="#">
<input name="name" type="text">
<input type="submit" name="submit">
</form>
<?php 
if(isset($_POST['submit'])){
if (isset($_POST['name'])) {
    $name = $_POST['name'];
}
$to = "vishniakovcz@gmail.com";
$charset = "windows-1251";
$subject = "Тема";
$message = "Имя: $name \n";
$from = "hotelwelcome@mail.com";

$send = mail($to,$subject,$message, "from:" . $from);
if ($send == 'true'){
    echo "mail sent";
}
}
?>