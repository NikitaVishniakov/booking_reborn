<?php
    require_once("funcs.php");
    require_once("connection.php");
//    session_start();
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = $link->query("SELECT * FROM booking WHERE id = {$id}");
        $row = $query->fetch_array();
        $duration = getDaysCount($row['dateStart'], $row['dateEnd']);
        $from = date_create($row['dateStart'])->format("d.n.Y");
        $to = date_create($row['dateEnd'])->format("d.n.Y");
        $checkIn = [];
        if($row['checkIn'] == 0){
            array_push($checkIn, "checkIn");
            array_push($checkIn, "Подтвердить заезд");
        }
        else{
            array_push($checkIn, "cancel_checkIn");
            array_push($checkIn, "Отменить заезд");
        }
        if($row['breakfast']){
            $breakfast = "Да";
        }
        else{
            $breakfast = "Нет";
        }
        if($row['guestPhone'] == ''){
            $phone = "Не указан";
        }
        else {
            $phone = $row['guestPhone'];
        }
        if($row['deposit']){
            $deposit_action = "returnDeposit";
            $button_text = "Вернуть залог";
        }
        else{
            $deposit_action = "getDeposit";
            $button_text = "Залог получен";
        }
        if($row['comment'] == ''){
            $hide = "hidden";
        }
        else {
            $hide = '';
        }
        $row['bookingDate'] = date_create($row['bookingDate'])->format("d.m.Y H:i");
?>
<div class="modal_confirm">
    <div class="modal-dialog" role="document">
    </div>
        
</div>
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Просмотр брони</h4>
      </div>
<!--      <form class="form" method="get" action="#">-->
          <div class="modal-body">
               <div class="buttons">
                   <div class="form-group">
                    <button class="btn btn-info action" name="action" value="edit">Редактировать бронь</button>
                    <button class="btn btn-warning action" name="action" value="cancel" >Отмена брони</button>
                    <button class="btn btn-danger action" name="action" value="delete" >Удалить бронь</button>
                   </div>
                   <div class="form-group">
                    <?php if($_SESSION['status'] == "main"){ ?>
                    <button class="btn btn-warning action" name="action" value="<?php echo $checkIn[0] ?>" ><?php echo $checkIn[1] ?></button> <?php } ?>
                        <?php if($row['checkIn']){ ?>
                       <button class='btn btn-warning action' name='action' value='<?php echo $deposit_action; ?>' id='<?php echo $row['id']; ?>' title="<?php echo $row['guestName']; ?>"><?php echo $button_text; ?></button>
                       <?php } ?>
                   </div>
                </div>
              <div class="col-md-10 col-md-offset-1">
                  <div class="row">
                        <div class="col-md-6 text-bold">ID бронирования:</div>
                        <div class="col-md-6"><p id="id"><?php echo $row['id']; ?></p></div>
                  </div>    
                  <div class="row">
                        <div class="col-md-6 text-bold">Имя гостя:</div>
                        <div class="col-md-6"><?php echo $row['guestName']; ?></div>
                  </div>    
                  <div class="row">
                        <div class="col-md-6 text-bold">Номер телефона:</div>
                        <div class="col-md-6"><?php echo $phone;?></div>
                  </div>        
                  <div class="row">
                        <div class="col-md-6 text-bold">Бронирование:</div>
                        <div class="col-md-6"><?php echo "c ".$from." по ".$to." (Количество ночей: ".$duration.")"; ?></div>
                  </div>  
                  <div class="row">
                        <div class="col-md-6 text-bold">Номер:</div>
                        <div class="col-md-6"><?php echo $row['roomNum']; ?></div>
                  </div>  
                  <div class="row">
                        <div class="col-md-6 text-bold">Количество гостей:</div>
                        <div class="col-md-6"><?php echo $row['guestsNum']; ?></div>
                  </div>  
                  <div class="row">
                        <div class="col-md-6 text-bold">Заврак:</div>
                        <div class="col-md-6"><?php echo $breakfast; ?></div>
                  </div>  
                  <div class="row">
                        <div class="col-md-6 text-bold">Общая сумма:</div>
                        <div class="col-md-6"><?php echo $row['amount']." руб."; ?></div>
                  </div> 
                  <div class="row">
                        <div class="col-md-6 text-bold">Тип оплаты:</div>
                        <div class="col-md-6"><?php echo $row['payment']; ?></div>
                  </div>   
                  <div class="row comment <?php echo $hide; ?>">
                        <div class="col-md-6 text-bold">Комментарий:</div>
                        <div class="col-md-6"><?php echo $row['comment']; ?></div>
                  </div>
                  <div class="row">
                        <div class="col-md-6 text-bold">Дата добавления:</div>
                        <div class="col-md-6"><?php echo $row['bookingDate']; ?></div>
                  </div>    
                  <div class="row">
                        <div class="col-md-6 text-bold">Кем добавлено:</div>
                        <div class="col-md-6"><?php echo $row['whoAdd']; ?></div>
                  </div>   
              </div>
              <?php
                    
              ?>
              <div class="row">
              </div>
          </div>
<!--      </form>-->
    </div>
</div>
<?php
    }
?>
<script>
    $(document).ready(function(){
       $('.close').click(function(){
                $('.layout').addClass('hidden');
                $('.show_booked').addClass('hidden');
            });
        $("button[name='action']").click(function(){
            var action = $(this).prop("value");
            var id = $('#id').text();
            if(action == "returnDeposit" || action == "getDeposit"){
                id = $(this).attr("id");
                var name = $(this).attr("title");
                $.ajax({
                  url: "actions.php",
                  type: "GET",
                  data: {
                    action: action,
                    name: name,
                    id: id
                  },
                  success: function(data){
//                       $('.show_booked, .layout').removeClass('hidden');
                        $('.show_booked').html(data);
                  }
                });
            }
            if(action =='delete' || action == 'cancel' || action == 'checkIn' || action == 'cancel_checkIn'){
                if(action =='delete'){
                    var modalText = "удаление";
                }
                else {
                    var modalText = "действие";
                }
                var agree = confirm("Подтвердите " + modalText);
            }
           if(agree || action == "edit"){
                $.ajax({
                  url: "actions.php",
                  type: "GET",
                  data: {
                    action: action,
                    type: "edit",
                    id: id
                  },
                  success: function(data){
                    if(action == "edit") {
                         $('.modal_booking, .layout').removeClass('hidden');
                        $('.show_booked').addClass('hidden');
                        $('.modal_booking').html(data);
                    }
                      else {
                        $('.show_booked, .layout').removeClass('hidden');
                        $('.show_booked').html(data);
                    }
                  }
                });
            }
        });
    
    });
</script>