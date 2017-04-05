<?php include("header.php");
$dates = [];
$days_option = [3,10,15,30];
if(isset($_GET['days'])){
    $days = $_GET['days'];
}
else {
    $days = 3;
}
for($i = $days - 1; $i >= 0; $i--){
    $day = new dayBalance($i);
    array_push($dates, $day);
}
$dates = array_reverse($dates);
$permission = permissionControl();
//    echo "<p>".$today->startDay." - ".$today->endDay."</p>";
//    echo "<p>Поступления</p>";
//
//    foreach($today->getPayments("+") as $row){
//        echo "<p>{$row['name']}, {$row['whoPay']}, {$row['type']} - {$row['amount']}</p>";
//    }
//    echo "<p>Списания</p>";
//    foreach($today->getPayments("-") as $row){
//        echo "<p>{$row['name']}, {$row['whoPay']},  - {$row['amount']}</p>";
//    }
//
    
//        echo "<p>".$val['type'].": ".$val['total']."</p>";
//    }
//    echo "<p>Остаток в кассе: ".$today->getBalance()."<hr>";
?>
<div class="show_booked hidden"></div>
<div class="container-fluid users-container">
    <?php include("finance-menu.php"); ?>
    <div class="col-md-9 main-body">
            <form action="#" method="get" class="col-md-6 col-md-offset-6">
                <div class="col-md-9 form-group">
                    
                    <label class="" for="days">Кол-во отображаемых смен:</label>
                    <select name="days" id="days" class="col-md-4 " style="width:70px; float:none; display:inline-block; margin-left:10px;">
                        <?php foreach($days_option as $option){
                                    if($days == $option){
                                        $selected = "selected";
                                    }
                                    else{
                                        $selected = "";
                                    }
                                    echo "<option {$selected}>{$option}</option>";
                                } 
                        ?>
                    </select>
                    
                </div>
                <div class="form-group col-md-2">
                    <input type="submit" name="submit" class="btn btn-success btn-small" value="Подтведить">
                </div>
            </form>
<?php foreach($dates as $today){ ?>
<div class="row">
    <p class="finance-header"><?php echo date_format(date_create($today->startDay), "d.m")." - ".date_format(date_create($today->endDay), "d.m"); ?></h4>
    <div class="col-md-6 no_padding border-right">
        <p class="finance-colomn colomn-left btn-success plus" >Поступления</p>
        <table class="table table-condensed" >
            <thead>
                <tr>
                    <th>Источник</th>
                    <th>Вид платежа</th>
                    <th>Плательщик</th>
                    <th>Сумма</th>

                </tr>
            </thead>
            <tbody class="table-hover">
    <?php foreach($today->getPayments("+") as $row){ ?>
                <tr id="<?php echo $row['id']; ?>" class="payment">
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['whoPay']; ?></td>
                    <td><?php echo $row['amount']; ?> руб.</td>

                </tr>
    <?php } ?> 
                <tr class="<?php echo $permission; ?>">
                    <td colspan="5"><button title="<?php echo $today->startDay; ?>" class="btn btn-success payment-add" name="action" value="plus">Добавить поступление</button></span></td>
                </tr>
            </tbody>
        </table>
    </div> 
    <div class="col-md-6 no_padding">
        <p class="finance-colomn colomn-right btn-warning minus" >Списания</p>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Цель</th>
                    <th>Сумма</th>
                    <th>Кто</th>

                </tr>
            </thead>
            <tbody class="table-hover">
    <?php foreach($today->getPayments("-") as $row){ ?>
             <tr id="<?php echo $row['id']; ?>"  class="payment">
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['amount']; ?> руб.</td>
                <td><?php echo $row['whoAdd']; ?></td>
             </tr>
    <?php } ?>
                <tr class="">
                    <td colspan="4"><button title="<?php echo $today->startDay; ?>" class="btn btn-warning payment-add" name="action" value="minus">Добавить списание</button></span></td>
                </tr>
            </tbody>
        </table>
    </div>
   
</div>
 <div class="row">
     <div class="col-md-6 col-md-offset-6">
 <?php
    $array = $today->getTotal("+");
    foreach($array as $val){ ?>
    <p><?php echo "<span class='text-bold'>{$val['type']}:</span> {$val['total']}"; ?> руб.</p>
<?php } ?>
    <p><span class="text-bold">Остаток в кассе:</span><?php echo $today->getBalance(); ?> руб.</p>
     </div>
</div>
<?php } ?>    
    </div>
</div>
<script>
$(document).ready(function(){
    $('.close').click(function(){
        $('.layout').addClass('hidden');
        $('.show_booked').addClass('hidden');
    });
    $("button[name='action']").click(function(){
        var action = $(this).prop("value");
        var date = $(this).attr("title");
        $.ajax({
              url: "actions.php",
              type: "GET",
              data: {
                action: action,
                date: date
              },
              success: function(data){
                    $('.show_booked, .layout').removeClass('hidden');
                    $('.show_booked').html(data);
                }

        });
    });

    $('.payment').click(function(){
        var id = $(this).attr("id");
        var action = "showPayment";
        $.ajax({
              url: "actions.php",
              type: "GET",
              data: {
                action: "showPayment",
                id: id
              },
              success: function(data){
                    $('.show_booked, .layout').removeClass('hidden');
                    $('.show_booked').html(data);
                }

        });
    });

});
</script>
<?php
 include("footer.php"); ?>