     <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Информация о транзакции</h4>
      </div>
<!--      <form class="form" method="get" action="#">-->
          <div class="modal-body">
               <div class="buttons">
                   <div class="form-group">
                    <button class="btn btn-info action" name="action" value="edit_transaction">Редактировать транзакцию</button>
                    <button class="btn btn-danger action" name="action" value="delete_transaction" >Удалить</button>
                   </div>
                </div>
              <div class="col-md-10 col-md-offset-1">
                  <div class="row">
                        <div class="col-md-6 text-bold">ID транзакции:</div>
                        <div class="col-md-6"><p id="id"><?php echo $row['id']; ?></p></div>
                  </div>    
                  <div class="row">
                        <div class="col-md-6 text-bold">Название:</div>
                        <div class="col-md-6"><?php echo $row['name']; ?></div>
                  </div>    
                  <div class="row">
                        <div class="col-md-6 text-bold">Дата:</div>
                        <div class="col-md-6"><?php echo date_format(date_create($row['date']), "d.m.Y H:i");?></div>
                  </div>        
                  <div class="row">
                        <div class="col-md-6 text-bold">Вид оплаты:</div>
                        <div class="col-md-6"><?php echo $row['type']; ?></div>
                  </div>  
                  <div class="row">
                        <div class="col-md-6 text-bold">Плательщик:</div>
                        <div class="col-md-6"><?php echo $row['whoPay']; ?></div>
                  </div>  
                  <div class="row">
                        <div class="col-md-6 text-bold">Комментарий:</div>
                        <div class="col-md-6"><?php echo $row['comment']; ?></div>
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
<script>
    $(document).ready(function(){
       $('.close').click(function(){
                $('.layout').addClass('hidden');
                $('.show_booked').addClass('hidden');
            });
        $("button[name='action']").click(function(){
            var action = $(this).prop("value");
            var id = $('#id').text();
                $.ajax({
                      url: "actions.php",
                      type: "GET",
                      data: {
                        action: action,
                        id: id
                      },
                      success: function(data){
    //                       $('.show_booked, .layout').removeClass('hidden');
                            $('.show_booked').html(data);
                  }
                });
            }
        });
    });
</script>