<div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" action="actions.php" method="post">
          <div class="modal-header">
            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Почасовое продление</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                      <div class="form-group">
                        <label for="prolongation-hours">Продление до:</label>
                        <select name="hours" class="form-control" id="prolongation-hours"><?php prolongationOptions(); ?></select>
                      </div>
                      <p><span class="text-bold">Стоимость:</span> <span id='prolongation-price'></span>руб.</p>
                      <input type="text" name="prolongation_cost" id="prolongation-price-input" class="hidden">
                      <input type="text" name="bookingId" id="input-prolongation-hours-id" class="hidden" value="">
                      <input type="text" name="input-hours" id="input-hours" class="hidden">
                  </div>
              </div>
          </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default cancel">Отменить</button>
            <input type="submit" class="btn btn-primary" name="submit_prolongation_hours" value="Подтвердить">
        </div>
      </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.layout, .close').click(function(){
                $('.layout').addClass('hidden');
                $('.modal-box').addClass('hidden');
        });
        $('.cancel').click(function(){
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
        });
        function countPrice(){
            var hour = $('#prolongation-hours').val();
            var id = $('#bookingId').text();
            $('#input-prolongation-hours-id').val(id);
            $.ajax({
                  url: "actions.php",
                  type: "GET",
                  data: {
                    action: "prolongation-count-cost",
                    hours: hour,
                    id: id
                  },
                    success: function(data){
                        var arr = data.split(',');
                       $('#prolongation-price').text(arr[0]);
                       $('#prolongation-price-input').val(arr[0]);
                       $('#input-hours').val(arr[1]);
                    }
            });
        }
        countPrice();
        $('#prolongation-hours').change(function(){
            countPrice();
        });
    });
</script>