<?php
//include "header.php";
$header = "Просмотр данных платежа";
$payment = $link->query("SELECT * FROM costs WHERE ID = $id")->fetch_array();
$parent = $link->query("SELECT * FROM costs_categories WHERE NAME = '{$payment['CATEGORY']}'")->fetch_array()['ID'];
$date = date_format(date_create($payment['DATE']), "d.m.Y H:i");
?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form class="form" id="form" action="actions.php" method="post">
        <input type="hidden" id="id-cost" name="ID" value="<?php echo $id; ?>">
      <div class="modal-header">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $header; ?></h4>
      <?php if($_SESSION['status'] == "main"){ ?>
        <a href="#" class="btn btn-info" id="edit-payment">Редактировать</a>
        <a href="#" class="btn btn-danger" title="<?php echo $payment['id']; ?>" name="delete-payment" id="delete-payment">Удалить</a>
          <?php } ?>
      </div>
          <div class="modal-body">
              <table class="table modal-costs-table">
                    <tr>
                        <td id="cost-category-label-modal">Категория </td><td><span class="show"><?php  echo $payment['CATEGORY']; ?></span>
                        <select id="cost-category-modal" class="hidden edit form-control" name="cost_category">
                            <option value=""> Не выбрано</option>
                            <?php selectCostCategories($payment['CATEGORY']); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <td>Подкатегория </td><td><span class="show"><?php  echo $payment['SUB_CATEGORY']; ?></span>
                        <select id="cost-subcategory-modal" class="hidden edit form-control" name="cost_sub_category"><?php selectCostSubCategories($parent, $payment['SUB_CATEGORY']); ?></select>
                        </td>
                    </tr>
                  <tr>
                        <td>Способ оплаты</td><td><span class="show"><?php echo $payment['PAYMENT_TYPE']; ?></span>
                            <select class="form-control edit hidden" name="PAYMENT_TYPE"><?php selectPaymentType($payment['PAYMENT_TYPE']); ?></select>
                        </td>
                    </tr>
                    <tr>
                        <td>Дата внесения</td><td><span><?php echo $date;?></span></td>
                    </tr>
              </table>
              <table class="table modal-costs-table margin-left-20">
                    <tr>
                        <td>Наименование: </td>
                        <td><span class="show"><?php echo $payment['NAME']; ?></span>
                        <input required type="text" id="cost-name" name="cost_name" value="<?php echo $payment['NAME']; ?>" class="edit form-control hidden">
                        </td>
                    </tr>
                    <tr>
                        <td>Сумма: </td>
                        <td><span class="show"><?php echo $payment['AMOUNT']; ?></span>
                        <input required type="text" id="amount" name="cost_amount" value="<?php echo $payment['AMOUNT']; ?>" class="edit form-control hidden">
                        </td>
                    </tr>
                    <tr>
                        <td id="cost-units-label-modal">Единица измерения: </td>
                        <td> 
                            <span class="show"><?php echo $payment['UNIT']; ?></span>
                            <select class="edit hidden form-control" id="costs-units-modal" name="costs-units">
                            <option value=""> Не выбрано</option>
                            <?php selectGetUnity(); ?>
                            </select>
                        </td>
                    </tr>
                  <tr>
                    <td>Количество: </td>
                    <td>
                        <span class="show"><?php echo $payment['QUANTITY']; ?></span>
                        <input type="text" class="edit hidden form-control" value="<?php echo $payment['QUANTITY']; ?>" name="cost-quantity" id="cost-quantity-modal">
                    </td>
                  </tr>
              </table>
              <div class="clear"></div>
            </div>
            <div class="modal-footer">
                <input type='submit' class="btn hidden edit btn-success" name="edit-cost" value="Сохранить">
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
                  var id = $('#id-cost').val();
                  var answer = confirm("Подтвердите удаление издержки");
                if(answer){
                $.ajax({
                    url: "actions.php",
                    type: "get",
                    data: {
                        action: "delete-cost",
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
                $('.modal-cost').addClass('hidden');
            });
            $('#cost-category-modal').on("change", function(){
             var parent_id = $('#cost-category-modal').val();
                 $.ajax({
                    url: "actions.php",
                    type: 'GET',
                    data:{
                        action: 'get_subcategories',
                        parent_id: parent_id
                    },
                    success: function(data){
                       $('#cost-subcategory-modal').html(data);
                    }
                });
            });
           
            $('#form').submit(function(){
                var parent_val = $('#cost-category-modal').val();
                var quantity = $('#cost-quantity-modal').val();
                var units = $('#costs-units-modal').val()
                var error = false;
                if(parent_val == ''){
                    $('#cost-category-modal').addClass('error-input');
                    $('#cost-category-label-modal').addClass('red');
                    error = true;
                }
                else{
                    $('#cost-category-modal').removeClass('error-input');
                    $('#cost-category-label-modal').removeClass('red');
                }
                if(quantity == '' || quantity == 0){
                        $('#costs-units-modal').removeClass('error-input');
                        $('#cost-units-label-modal').removeClass('red');
                }
                    else{
                        if(units == ''){
                            prompt(quantity)
                            $('#costs-units-modal').addClass('error-input');
                            $('#cost-units-label-modal').addClass('red');
                            error = true;
                        }
                    }

                if(error){
                    return false;
                }
            });
       });
</script>