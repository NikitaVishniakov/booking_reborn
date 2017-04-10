<!--
  <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css?t=<?php echo(microtime(true)); ?>">
-->
<!--    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>-->
<?php 
    include("header.php");
?>
<div class="modal">
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
                      <p>Итого к оплате:</p>
                  </div>
                  <div class="col-md-3 form-group">
                      <input type="text" name="amount" class="form-control" value="<?php echo $total; ?>">
                  </div>
                  <div class="col-md-3">руб.</div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <p>Способ оплаты:</p>
                  </div>
                  <div class="col-md-6">
                      
                      <div class="form-group">
                          <select class="form-control" name="type">
                            <option>Наличные</option>
                            <option>Безналичный расчет</option>
                          </select>
                      </div>
                  </div>
              </div>  
              <div class="row">
                  <div class="col-md-6 col-md-offset-6">
                      <div class="form-group">
                        <label for="deposit">Залог внесен</label>
                        <input type="checkbox" name="deposit" id="deposit" value="deposit" class="l">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <p>Комментарий:</p>
                  </div>
                  <div class="col-md-6">
                      
                      <div class="form-group">
                            <textarea class="form-control" name="comment"></textarea>
                      </div>
                  </div>
              </div>
          </div>
         <div class="modal-footer">
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">Отменить</button>
                <input type="submit" class="btn btn-primary" name="submit_checkIn" value="<?php echo $header; ?>">
                <input type="text" name="id" class="hidden" value="<?php echo $query['id']; ?>">
             
             
          </div>
  </form>
  </div>
</div>
<script>
    $(document).ready(function(){
    $('.layout, .close, .cancel').click(function(){
                $('.layout').addClass('hidden');
                $('.modal_confirm').addClass('hidden');
                $('.modal-small').addClass('hidden');
        });
    });
</script>
</div>

<?php
    include("footer.php");
?>
