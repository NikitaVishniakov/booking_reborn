<?php 
    include("header.php");
    $date = date("d.m.Y");
    $deposits = getDepositsAmount($date);
    $class = "";
?>
<div class="show_booked hidden"></div>
<div class="container-fluid users-container">
<?php
    include("components/finance-menu.php");
?>
    <div class="col-md-9 main-body">
        <h1>Залоги</h1>
        <p>Сегодня, <?php echo $date; ?>, у вас 
            <?php if($deposits[0] == 0){echo "нет залогов"; $class ="hidden";} 
            else {
                if(substr($deposits[0], -1) == '1'){
                    $text = "залог";
                }
                elseif(substr($deposits[0], -1) > 1 && substr($deposits[0], -1) < 5 ){
                    $text = "залога";
                }
                else{
                    $text = "залогов";
                }
            echo "{$deposits[0]} {$text}, на сумму {$deposits[1]} рублей."; }?></p>
        <table class="table table-bordered <?php echo $class; ?>">
            <thead>
                <tr>
                    <td>Номер комнаты</td>
                    <td>Кто внес</td>
                    <td>Тип залога</td>
                    <td>Сумма</td>
                </tr>
            </thead>
            <tbody>
                <?php getDeposits($date); ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    include("footer.php");
?>