<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form class="form" action="actions.php" method="post">
      <div class="modal-header">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Предоплата</h4>
      </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                      <p>Сумма предоплаты(1 сутки):</p>
                  </div>
                  <div class="col-md-3 form-group">
                      <input type="text" name="amount" class="form-control" value="<?php echo $pre_pay; ?>">
                      <input type="text" name="type" class="hidden" value="Безналичный расчет">
<!--                      <input type="text" name="name" class="hidden" value="Безначличный расчет">-->
                  </div>
                  <div class="col-md-3">руб.</div>
              </div>
          </div>
         <div class="modal-footer">
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">Отменить</button>
                <input type="submit" class="btn btn-primary" name="submit_pre_pay" value="Внести предоплату">
                <input type="text" name="id" class="hidden" value="<?php echo $booking['id']; ?>">
             
             
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