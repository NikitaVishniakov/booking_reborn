<?php
require_once("connection.php");
if(isset($_GET['id'])){
    $select = $link->query("SELECT * FROM booking WHERE id={$_GET['id']}");
//    echo "SELECT * FROM booking WHERE id={$_GET['id']}";
    if(mysqli_num_rows($select) == 0){
        header("location:index.php");
    }  
}
else{
    header("location:index.php");
}
require_once("header.php");
$profile = $select->fetch_array();
$bookingId = $profile['id'];
$booker = $profile['booker'];
$dateStart = date_format(date_create($profile['dateStart']), "d.m.Y");
$dateEnd = date_format(date_create($profile['dateEnd']), "d.m.Y");
$nights = getDaysCount($profile['dateStart'], $profile['dateEnd']);
$roomNum = $profile['roomNum'];
$paymentType = $profile['payment'];
$guestsNum = $profile['guestsNum'];
$breakfast_val = $profile['breakfast'];
if($breakfast_val){
    $checked="checked";
    $breakfast = "Да";
}
else{
    $checked="";
    $breakfast = "Нет";
}
$checkIn = [];
    if($profile['checkIn']==0){
        array_push($checkIn, "checkIn");
        array_push($checkIn, "Подтвердить заезд");
        array_push($checkIn, "btn-success");
    }
    else{
        array_push($checkIn, "cancel_checkIn");
        array_push($checkIn, "Отменить заезд");
        array_push($checkIn, "btn-danger");
    }
$guestName = $profile['guestName'];
$phoneNum = $profile['guestPhone'];
$dateAdded = $profile['bookingDate'];
$whoAdd = $profile['whoAdd'];
$source = $profile['source'];
$amount = $profile['amount'];
$servicesAmount = getServicesAmount($bookingId);
$total = intval($amount) + intval($servicesAmount);
$payed = getUserPayments($bookingId);
if(!$payed){
    $payed = 0;
}
$toPay = getDebt($bookingId, $amount);
if($toPay > 0){
    $debtClass = "not-payed";
    $debtButtonClass = "";
}
else{
    $debtClass = "";
    $debtButtonClass = "hidden";
}
$keyDeposit = $profile['deposit'];
$gatesDeposit = $profile['depositGates'];
$comment = $profile['comment'];
if($keyDeposit){
    $depositText = "Внесен";
    $depositActionText = "Вернуть залог";
    $depositAction = "returnDeposit";
    $depositClass = "btn-success";
}
else{
    $depositText = "Нет";
    $depositActionText = "Внести залог";
    $depositAction = "getDeposit";
    $depositClass = "btn-warning";
}
if($gatesDeposit){
    $gatesDepositText = "Внесен";
    $gatesDepositActionText = "Вернуть залог";
    $gatesDepositAction = "returnGatesDeposit";
    $gatesDepositClass = "btn-success";
}
else{
    $gatesDepositText = "Нет";
    $gatesDepositActionText = "Внести залог";
    $gatesDepositAction = "getGatesDeposit";
    $gatesDepositClass = "btn-warning";
}
if($profile['canceled'] == 1){
    $canceled_alarm = "";
    $cancel_btn = "hidden";
}
else{
    $canceled_alarm = "hidden";
    $cancel_btn = "";
}
$date = date("Y-m-d H:i:s");
?>
<div class="modal_confirm modal-payment hidden">
<?php require("modals/modal_payment_user.php"); ?>
</div>
<div class="modal-small"></div>
<div class="canceled-alarm <?php echo $canceled_alarm; ?>">
    <p>Бронь отменена</p>
</div>
<div class="page-body">
    <div class="col-md-10 left-info">
        <div class="main-info">
            <div class="col-md-6 ">
                <div class="booking-info">
                <form method="post" action="actions.php">
                  <div class="row booking-id">
                        <div class="col-md-6">ID бронирования: <span id="bookingId"><?php echo $bookingId; ?></span></div>
                        <div class="col-md-6"></div>
                  </div>    
                  <div class="row">
                        <div class="col-md-6 text-bold">Бронировал:</div>
                        <div class="col-md-6 view"><?php echo $booker; ?></div>
                        <input type="text" class="col-md-6 edit hidden" name="booker" value ="<?php echo $booker; ?>">
                        <input type="text" class="col-md-6 hidden" name="bookingId" value ="<?php echo $bookingId; ?>">
                  </div>    
                  <div class="row view">
                        <div class="col-md-6 text-bold view">Даты:</div>
                        <div class="col-md-6 view"><?php echo $dateStart." - ".$dateEnd; ?></div>
                  </div>
                  <div class="row edit hidden">
                      <div class="col-md-6 text-bold">Въезд:</div>
                      <input type="text" class="col-md-6 edit hidden datepicker-here" name="dateStart" value ="<?php echo $dateStart; ?>">
                  </div>
                  <div class="row edit hidden">
                      <div class="col-md-6 text-bold">Выезд:</div>
                      <input type="text" class="col-md-6 edit hidden datepicker-here" name="dateEnd" value ="<?php echo $dateEnd; ?>">

                  </div>
                  <div class="row view">
                        <div class="col-md-6 text-bold">Кол-во ночей:</div>
                        <div class="col-md-6"><?php echo $nights; ?></div>
                  </div>
                  <div class="row">
                        <div class="col-md-6 text-bold">Номер:</div>
                        <div class="col-md-6 view"><?php echo $roomNum; ?></div>
                        <select name="roomNum" class="col-md-6 edit hidden">
                            <?php selectRoom($roomNum); ?>
                        </select>
<!--                        <input type="text" class="col-md-6 edit hidden" name="roomNum" value ="<?php echo $roomNum; ?>">-->
                  </div>
                  <div class="row">
                        <div class="col-md-6 text-bold">Количество гостей:</div>
                        <div class="col-md-6 view"><?php echo $guestsNum; ?></div>
                        <select name="guestsNum" class="col-md-6 edit hidden">
                         <?php selectGuests($guestsNum); ?>
                        </select>
                  </div>     
                 <div class="row">
                        <div class="col-md-6 text-bold">Заврак:</div>
                        <div class="col-md-6 view"><?php echo $breakfast; ?></div>
                        <input type="checkbox" <?php echo $checked; ?> class="col-md-6 edit hidden" name="breakfast">
                  </div>  
                 <div class="row">
                        <div class="col-md-6 text-bold">Имя гостя:</div>
                        <div class="col-md-6 view"><?php echo $guestName; ?></div>
                        <input type="text" class="col-md-6 edit hidden" name="guestName" value ="<?php echo $guestName; ?>">
                  </div>  
                  <div class="row">
                        <div class="col-md-6 text-bold">Номер телефона:</div>
                        <div class="col-md-6 view"><?php echo $phoneNum; ?></div>
                        <input type="text" class="col-md-6 edit hidden" name="phoneNum" value ="<?php echo $phoneNum; ?>">
                  </div>        
                  <div class="row">
                        <div class="col-md-6 text-bold">Способ оплаты:</div>
                        <div class="col-md-6 view"><?php echo $paymentType; ?></div>
                            <select id="payments" name="payment" class="col-md-6  edit hidden">
                                <?php selectPayments($paymentType); ?>
                            </select>
                  </div>    
                  <div class="row view">
                        <div class="col-md-6 text-bold">Дата добавления:</div>
                        <div class="col-md-6"><?php echo $dateAdded; ?></div>
                  </div>    
                  <div class="row view">
                        <div class="col-md-6 text-bold">Кем добавлено:</div>
                        <div class="col-md-6"><?php echo $whoAdd; ?></div>
                  </div> 
                  <div class="row">
                        <div class="col-md-6 text-bold">Источник:</div>
                        <div class="col-md-6 view"><?php echo $source; ?></div>
                        <select name="source" class="col-md-6 edit hidden">  
                            <?php 
foreach($sources as $option){
    $selected = "";
    if($source == $option){
        $selected = "selected";
    }
    echo "<option {$selected}>{$option}</option>";
}
?>
                        </select>
                  </div>
                  <div class="row">
                        <a href="#" id="edit-info" class="col-md-6 col-md-offset-6 btn btn-info view">Редактировать</a>
                        <input type="submit" name="submit_user_edit" id="save" class="col-md-4 col-md-offset-1 btn btn-success edit hidden" value ="Сохранить">
                        <a href="#" id="cancel" class="col-md-4 col-md-offset-2 btn btn-default edit hidden">Отмена</a>
                  </div>
                </form>
                </div>
            </div>
            <div class="col-md-6 payment-info">
                <div class="row amount-big">
                    <div class="col-md-3 text-bold">Сумма:</div>
                    <div class="col-md-8 col-sm-10 view-amount"><?php echo $amount; ?> руб.</div>
                    <form class="edit-amount col-md-8 col-sm-10 hidden" action="actions.php" method="post">            
                        <input class="col-md-6 " name="amount" type="text" value="<?php echo $amount; ?>">
                        <input type="text" name="id" class="hidden" value="<?php echo $bookingId; ?>">
                        <input name="submit-amount" type="submit" value="Ок" class="col-md-2 btn btn-success btn-small">
                        <a href="#" id="cancel-amount" class="col-md-4 btn btn-default btn-small">Отмена</a>
                    </form>
                    <div class="col-md-1 col-sm-2 view-amount" id="edit-amount"><span class="glyphicon glyphicon-pencil"></span></div>
                </div>
                <div class="contaner-fluid deposit-block">
                    <div class="row">
                        <div class="col-md-6 text-bold">Залог за ключ:</div>
                            <div class="col-md-3"><?php echo $depositText; ?></div>
                            <button name="action" value="<?php echo $depositAction; ?>" class="col-md-3 btn btn-small <?php echo $depositClass; ?> btn-deposit"><?php echo $depositActionText; ?></button>                          
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-bold">Залог за ключ от ворот:</div>
                        <div class="col-md-3"><?php echo $gatesDepositText; ?></div>
                        <button  name="action" value="<?php echo $gatesDepositAction; ?>" class="col-md-3 btn btn-small <?php echo $gatesDepositClass; ?> btn-deposit"><?php echo $gatesDepositActionText; ?></button>
                    </div>
                </div>
                 <h3>Оплата</h3 >
                <div class="container-fluid check-desk">
                    <div class="row">
                        <div class="col-md-6 text-bold">Проживание:</div>
                        <div class="col-md-6"><?php echo $amount; ?>  руб.</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-bold">Доп. услуги:</div>
                        <div class="col-md-6"><?php echo $servicesAmount; ?>  руб.</div>
                    </div>
                    <div class="row total-to-pay">
                        <div class="col-md-3 col-md-offset-5 text-bold">Итого:</div>
                        <div class="col-md-4"><?php echo $total; ?> руб.</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-bold">Оплачено:</div>
                        <div class="col-md-6"><?php echo $payed; ?>  руб.</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-bold <?php echo $debtClass; ?>">Задолженность:</div>
                        <div class="col-md-6 <?php echo $debtClass; ?>"><?php echo $toPay; ?>  руб.</div>
                    </div>
                     <div class="row">
                        <button id="<?php echo $bookingId; ?>" class="col-md-4 col-md-offset-7 btn-add-payment checkIn btn btn-success">Внести платёж</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-block">
            <div class="col-md-6 services-block">
                <p class="text-bold col-md-12 bottom-header">Доп. услуги:</p>
                <a href="#" id="edit-services"><span class="glyphicon glyphicon-pencil"></span></a>
                <div class="col-md-10 col-md-offset-1 services-list">
                    
                    <ul>
                      <?php getServices($bookingId); ?>
                      
                    </ul>
                </div>
                <div class="col-md-5 col-md-offset-7 total-services">Итого: <?php echo $servicesAmount; ?>  руб.</div>
            </div>
            <div class="col-md-6 comment-block">
                <p class="text-bold col-md-12 bottom-header">Комментарий:</p>
                <a href="#" id="edit-comment"><span class="glyphicon glyphicon-pencil comment-view"></span></a>
                <div class="col-md-10 col-md-offset-1 comment-field comment-view">
                    <?php echo $comment; ?>
                </div>
                <form action="actions.php" method="post" class="edit-comment hidden">
                    <textarea class="col-md-10 col-md-offset-1 comment-field" name="comment"><?php echo $comment; ?></textarea>
                    <div class="col-md-6 col-md-offset-6">
                        <input type="text" name="id" class="hidden" value="<?php echo $bookingId; ?>">
                        <input type="submit" name="submit_comment" class="btn btn-success btn-small" value="Сохранить">
                        <a href="#" id="cancel-comment" class=" btn btn-default btn-small edit-comment">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div> 
      <div class="col-md-2 right-actions">
          <h3>Действия</h3>
          <div class="row">
              <button name="action" value="<?php echo $checkIn[0]; ?>" class="col-md-10 col-md-offset-1 action btn <?php echo $checkIn[2]; ?>"><?php echo $checkIn[1]; ?></button>
            <button name="action" value="cancel" class="col-md-10 col-md-offset-1 btn btn-default <?php echo $cancel_btn; ?>">Отмена брони</button>
            <button name="action" value="delete" class="col-md-10 col-md-offset-1 btn btn-default">Удалить бронь</button>
            <button name="action" value="prolongation" class="col-md-10 col-md-offset-1 btn btn-default">Продление</button>
            <button name="action" class="col-md-10 col-md-offset-1 btn btn-default">Печать подверждения</button>
            <button name="action" class="col-md-10 col-md-offset-1 btn btn-default">Возврат д/с</button>
          </div>
          <h3>Доп. услуги</h3>
            <form class="services-form col-md-10 col-md-offset-1" action="actions.php" method="post">
                <div class="form-group">
                    <label for="services-list">Выбор услуги:</label>
                    <select id="services-list" class="form-control" name="service">
                        <?php $services = listOfServices();
                        foreach($services as $row) {
                            echo "<option value={$row['id']}>{$row['name']}({$row['price']} руб.)</option>";
                        }?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="services-num">Количество:</label>
                    <input type="number" class="form-control" name="quantity" id="services-num" value="1">
                </div>
                <input type="text" name="id" class="hidden" value="<?php echo $bookingId; ?>">
                <input type="submit" name="add_service" value="Подтвердить" class="btn btn-success col-md-10 col-md-offset-1">
            </form>
          </div>
    </div> 
<div class="modal-box modal-prolongation hidden">
</div>
<script>
    $(document).ready(function(){
        var disabledDays = [0, 6];
        $('#disabled-days').datepicker({
            onRenderCell: function (date, cellType) {
                if (cellType == 'day') {
                    var day = date.getDay(),
                        isDisabled = disabledDays.indexOf(day) != -1;

                    return {
                        disabled: isDisabled
                    }
                }
            }
        })
        $('#edit-info').click(function(){
            $('.view').addClass('hidden');
            $('.edit').removeClass('hidden');
        });
        $('#cancel').click(function(){
            $('.edit').addClass('hidden');
            $('.view').removeClass('hidden');
        });
        $('#edit-comment').click(function(){
            $('.comment-view').addClass('hidden');
            $('.edit-comment').removeClass('hidden');
        });
        $('#edit-amount').click(function(){
            $('.view-amount').addClass('hidden');
            $('.edit-amount').removeClass('hidden');
        });
        $('#edit-services').click(function(){
//            $('#edit-services').toggClass('hidden');
            $('.service-delete').toggleClass('hidden');
        });
        $('#cancel-comment').click(function(){
            $('.comment-view').removeClass('hidden');
            $('.edit-comment').addClass('hidden');
        });
        $('#cancel-amount').click(function(){
            $('.view-amount').removeClass('hidden');
            $('.edit-amount').addClass('hidden');
        });
        $('.btn-add-payment').click(function(){
            $('.modal-payment').removeClass('hidden');
            $('.layout').removeClass('hidden');
        });
        $('.layout, .close, .cancel').click(function(){
                $('.layout').addClass('hidden');
                $('.modal-payment').addClass('hidden');
                $('.modal-small').addClass('hidden');
        });
        $("button[name='deleteService']").click(function(){
            var action = "deleteService";
            var id = $(this).prop("value");
            $.ajax({
                  url: "actions.php",
                  type: "GET",
                  data: {
                    action: action,
                    id: id
                  },
                    success: function(){
                        location.reload();
                    }
            })
        });
        $('.btn-deposit').click(function(){
            var action = $(this).prop("value");
            var id = $('#bookingId').text();
            var name = $("input[name='guestName']").val();
                $.ajax({
                  url: "actions.php",
                  type: "GET",
                  data: {
                    action: action,
                    name: name,
                    id: id
                  },
                    success: function(){
                       location.reload();
                    }
                });
        });
        $("button[name='action']").click(function(){
            var action = $(this).prop("value");
            var id = $('#bookingId').text();
            var reload = 0;
//            prompt(name);
            if(action == 'prolongation'){
                $('.layout').removeClass('hidden');
               $('.modal-prolongation').removeClass('hidden');
                $.ajax({
                      url: "actions.php",
                      type: "GET",
                      data: {
                        action: "modal-prolongation-options"
                      },
                        success: function(data){
                           $('.modal-prolongation').html(data);
                        }
                });
            }
            if(action == 'delete'){
               var agree = confirm("Подтвердите удаление");
                reload = 1;
            }
            if(action == "cancel"){
                var agree = confirm("Подтвердите отмену бронирования");
            }
            if(action == "cancel_checkIn"){
                agree = 1;
            }
            if(action == "checkIn"){
                $.ajax({
                      url: "actions.php",
                      type: "GET",
                      data: {
                        action: action,
                        id: id
                      },
                      success: function(data){
//                                prompt(data);
                            $('.modal-small, .layout').removeClass('hidden');
                            $('.modal-small').html(data);
                        }
                });
            }       
            if(agree){
                $.ajax({
                  url: "actions.php",
                  type: "GET",
                  data: {
                    action: action,
                    id: id
                  },
                  success: function(data){
                    if(action == "delete" || action == "cancel_checkIn"){
                        location.reload();
                    }
                      else{
                           $('.modal-small, .layout').removeClass('hidden');
                            $('.modal-small').html(data);
                      }
                    }
                });
            }
        });
    });
</script>
<?php
require("footer.php");
?>