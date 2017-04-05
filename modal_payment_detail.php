<?php
//include "header.php";
$header = "Просмотр данных платежа";
$payment = $link->query("SELECT * FROM payments WHERE id = $id")->fetch_array();
if($payment['status'] = '+'){
    $class = 'bg-green';
}
else{
    $class = 'bg-red';
}
$date = date_format(date_create($payment['date']), "d.m.Y H:i");
?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form class="form" id="form" action="actions.php" method="post">
      <div class="modal-header">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $header; ?></h4>
      <?php if($_SESSION['status'] == "main"){ ?>
        <a href="#" class="btn btn-info" id="edit-payment">Редактировать</a>
        <a href="#" class="btn btn-danger" title="<?php echo $payment['id']; ?>" name="delete-payment" id="delete-payment">Удалить</a>
          <?php } ?>
      </div>
          <div class="modal-body">
              <h3 class="message"></h3>
              <table class="table">
                        <td>Вид платежа</td><td><span class="show"><?php  echo $payment['name']; ?></span>
                        <select class="hidden edit form-control" name="name"><?php selectPaymentName($payment['status'], $payment['name']); ?></select>
                  </td>
                    </tr>
                        <td>Способ оплаты</td><td><span class="show"><?php echo $payment['type']; ?></span>
                            <select class="form-control edit hidden" name="type"><?php selectPaymentType($payment['type']); ?></select>
                        </td>
                    </tr>
                        <td>Дата внесения</td><td><span><?php echo $date;?></span></td>
                    </tr>
                        <td>Сумма</td><td><span class="show"><?php echo $payment['amount']; ?></span>
                            <input type="text" class="hidden edit form-control" name="amount" value="<?php echo $payment['amount']; ?>">
                            <input type="text" class="hidden" name="id" value="<?php echo $payment['id']; ?>">
                        </td>
                    </tr>
                        <td>Плательщик</td><td><span><?php echo $payment['whoPay'] ?></span></td>
                    </tr>
                        <td>Комментарий</td><td><span class="show"><?php echo $payment['comment']; ?></span>
                        <input type="text" class="hidden edit form-control" name="comment" value="<?php echo $payment['comment']; ?>">
                        </td>
                    </tr>
                        <td>Кем внесен платеж</td><td><span><?php echo $payment['whoAdd']; ?></span></td>
                    </tr>
                    </tr>
              </table>
            </div>
            <div class="modal-footer">
                <input type='submit' class="btn hidden edit btn-success" name="edit-payment" value="Сохранить">
                <a href="#" class="btn edit hidden btn-default" id="cancel">Отмена</a>
          </div>
        </form>
    </div>
</div>
<script>
       $(document).ready(function(){
           $('#edit-payment').click(function(){
                $('.show').addClass('hidden');
                $('.edit').removeClass('hidden');
           });
            $('#cancel').click(function(){
                $('.show').removeClass('hidden');
                $('.edit').addClass('hidden');
            });
            $('#delete-payment').click(function(){
                  var id = $(this).attr("title");
                  var answer = confirm("Подтвердите удаление платежа");
                if(answer){
                $.ajax({
                    url: "actions.php",
                    type: "get",
                    data: {
                        action: "delete-payment",
                        id: id
                    },
                    success: function(data){
                        window.location.reload();
                    }

        });
                }
            });
            $('.close').click(function(){
                $('.layout').addClass('hidden');
                $('.show_booked').addClass('hidden');
            });
       });
</script>