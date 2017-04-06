<!--
<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css?t=<?php echo(microtime(true)); ?>">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
-->
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form class="form" action="actions.php" method="post">
      <div class="modal-header">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $header; ?></h4>
      </div>
          <div class="modal-body">
              <div class="row">
                      <div class="col-md-6">
                        <label for="amount">Сумма:</label>
                      </div>    
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" id="amount" name="amount" required class="form-control">
                                <input type="text" name="status" class="hidden" value="<?php echo $status; ?>">
                                <input type="text" name="date" class="hidden" value="<?php echo $date; ?>">
                            </div>
                        </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <label for="payment_type">Вид платежа:</label>
                  </div>
                  <div class="col-md-6">
                      
                      <div class="form-group">
                          <select class="form-control" id="payment_type" name="payment_type">
                              <?php foreach($options_array as $option){ ?>
                            <option><?php echo $option; ?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>
              </div>  
                <div class="row">
                  <div class="col-md-6">
                      <label for="type">Способ оплаты:</label>
                  </div>
                  <div class="col-md-6">
                      
                      <div class="form-group">
                          <select class="form-control" id="type" name="type">
                            <option>Наличные</option>
                            <option>Безналичный расчет</option>
                          </select>
                      </div>
                  </div>
              </div>  
              <div class="row">
                  <div class="col-md-6">
                      <label for="comment">Комментарий:</label>
                  </div>
                  <div class="col-md-6">
                      
                      <div class="form-group">
                            <textarea class="form-control" id="comment" name="comment"></textarea>
                      </div>
                  </div>
              </div>
          </div>
         <div class="modal-footer">
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">Отменить</button>
                <input type="submit" class="btn btn-primary" name="submit_payment" value="<?php echo $header; ?>">
             
             
          </div>
  </form>
  </div>
</div>
<script>
$(document).ready(function(){
    $('.close, .cancel').click(function(){
        $('.layout').addClass('hidden');
        $('.show_booked').addClass('hidden');
        $('.modal-small').addClass('hidden');
    });
});
</script>