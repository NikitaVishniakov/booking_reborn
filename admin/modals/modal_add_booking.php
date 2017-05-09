<?php 
require_once("../funcs.php");
        $header = "Добавить";
        $button = "insert";
//FIELDS
        $edit_hidden ="";
        $name = "";
        $phone = "";
        $breakfast = 0;
        $genius = 0;
        $total = 0;
        $price = "";
        $query_type = "insert";
        $comment = "";
        $insert_hidden = "hidden";
        $price_p = "";
        $payment = "0";
        $guestsNum = 1;
        $roomNum = 1;
//DATES
        $dateStart = "";
        $dateEnd = "";
        $plus = 1;

if(isset($_GET['date'])){
    $dateStart = date_format(date_create($_GET['date']), 'd.m.Y');
    $dateEnd =  date_format(date_modify(date_create($_GET['date']), '1day'), 'd.m.Y');
    $plus = 0;
}
if(isset($_GET['roomNum'])){
    $roomNum = $_GET['roomNum'] + 1;
}
?>
 <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> <?php echo $header; ?> бронь</h4>
         
      </div>
      <form novalidate="novalidate" class="form" method="POST" action="add_booking.php">
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-3"><span class="text-bold">Бронировал(а)</span></div>
                <div class="form-group col-md-6">
                    <input id="booker" required class="form-control" type="text" name="booker">
                </div>
              </div>
              <div class="row">
                  <div class="col-md-8 col-md-offset-2 hidden cant_add"><p class="red">Нельзя поставить бронь в указанные вами даты на данный номер.</p></div>
                  <div class="col-md-7"><p class="text-bold">Заселение:</p></div>
                  <div class="col-md-5"><p class="text-bold">Выезд:</p></div>
              </div>
              <div class="row">
                  <div class="form-group col-md-4">
                       <input type="text" id="dateStart" name="dateStart" value="<?php echo $dateStart; ?>" class="form-control datepicker-here" >
                  </div>
                  <div class="form-group col-md-4 col-md-offset-3">
                        <input type="text" id="dateEnd" name="dateEnd" value="<?php echo $dateEnd; ?>" class="form-control datepicker-here" >
                  </div>
              </div>
              <div class="row">
                <div class="col-md-4"><p class="text-bold">Выбор номера:</p></div>
                  <div class="col-md-offset-3 col-md-5"><p class="text-bold">Количество постояльцев:</p></div>
              </div>
              <div class="row">
                    <div class="form-group col-md-4">
                        <select name="roomNum" required id="roomNum" class="form-control">
                            <?php selectRoom($roomNum); ?>
                        </select>
                    </div> 
                  <div class="form-group col-md-offset-3 col-md-2">
                        <select name="guestsNum" id="guestsNum" class="form-control">
                            <?php if($_GET['type'] == "edit"){selectGuests($guestsNum);} ?>
                        </select>
                    </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-3">
                      <label for="breakfast">Завтрак</label>
                      <input type="checkbox" <?php isChecked($breakfast); ?> class="" value="1" name="breakfast" id="breakfast">
                  </div>                  
                  <div class="form-group col-md-5 col-md-offset-4">
                      <label for="genious">Genious-путешественник</label>
                      <input type="checkbox" <?php isChecked($genius); ?> class="" value="1" name="genious" id="genious">
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-5">
                      <label for="guestName">ФИО постояльца</label>
                      <input type="text" class="form-control" name="guestName" id="guestName" value="<?php echo $name; ?>">
                  </div>
                  <div class="form-group col-md-5 col-md-offset-2">
                     <label for="guestPhone">Телефон постояльца</label>
                     <input type="text" class="form-control" name="guestPhone" id="guestPhone" value="<?php echo $phone; ?>">
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-6">
                   <label for="payments">Способ оплаты:</label>
                    <select id="payments" name="paymentType" class="form-control">
                        <?php selectPayments($payment); ?>
                    </select>
                  </div>
                  <div class="form-group col-md-3 col-md-offset-3 hidden">
                   <label for="discount">Скидка:</label>
                      <div class="input-group">
                        <input type="text" name="discount" class="form-control" id="discount">
                        <div class="text-center input-group-addon">%</div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-6">
                      <label for="comment">Комментарий:</label>
                      <textarea class="form-control" name="comment" id="comment"><?php echo $comment; ?></textarea>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="source">Источник:</label>
                    <select requried class="form-control" name="source" id="source">
                        <option>Booking</option>
                        <option>Ostrovok</option>
                        <option>Постоянщик</option>
                        <option>С улицы</option>
                        <option>Другое</option>
                    </select>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-8 col-md-offset-4 price_box <?php echo $insert_hidden; ?>">
                    <div class="col-md-8">
                        <p class="price_label <?php echo $edit_hidden; ?>">Цена за ночь:</p>
                    </div>
                    <div class="col-md-4 ">
                        <p class="price_label <?php echo $edit_hidden; ?>" id="night_price" title="Изменить"></p>
                        <div class="form-group">
                            <input type="text" name="price" class=" form-control hidden" id="edit_price">
                            <input type="text" name="auto_price" value="" class=" form-control hidden" id="auto_price">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p class="price_label" >Общая стоимость:</p>
                    </div>
                    <div class="col-md-4">
                        <p class="price_label  <?php echo $edit_hidden; ?>" id="total_price"></p>
                        <input type="text" name="amount" value="<?php echo $total; ?>" class="form-control <?php echo $insert_hidden; ?>" id="total_price_input">
                    </div>
                  </div>
              </div>
              
          </div>
          <input type="text" name="query_type" class="form-control hidden" id="query_type" value="<?php echo $query_type;?>">
          <input type="text" name="id" class="form-control hidden" id="id" value="<?php echo $id;?>">
          <div class="modal-footer">
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">Отменить</button>
                <input type="submit" class="btn btn-primary add_booking" name="<?php echo $button; ?>" value="<?php echo $header; ?>">
          </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->


<script>
    $(document).ready(function() {
        function ajaxGuestsNum(){
        var roomNum = $('#roomNum').val();
        $.ajax({
                      url: "/admin/ajax_booking.php",
                      type: "GET",
                      data: {
                        type: "guestsNum",
                        roomNum: roomNum
                        
                      },
                      success: function(data){
                        $('#guestsNum').html(data);
                      }
                    });
                    
        
    }
    function addDays(date, days) {
        var dateArr = date.split('.');
        dateArr = dateArr[1] + "-" + dateArr[0] + "-" + dateArr[2];
        var result = new Date(dateArr);
        result.setDate(result.getDate() + days);
        var month  = result.getMonth() + 1;
        month = month.toString();
        if(month.length < 2){
            month = "0" + month;
        }
        var dateEnd = result.getDate() + "." + month + "." + result.getFullYear();
        return dateEnd;
    }
    function changeDate(){
            var dateStart = $('#dateStart').val();
            var dateEnd = addDays(dateStart, 1);
            $('#dateEnd').val(dateEnd);
        };
     
    function ajaxTotal(){
                    var dateStart = $('#dateStart').val();
                    var dateEnd = $('#dateEnd').val();
                    var roomNum = $('#roomNum').val();
                    var discount = $('#discount').val();
                    var guestsNum = $('#guestsNum').val();
                    var newPrice = $('#edit_price').val();
                    if(newPrice.length > 1) {
                         $.ajax({
                            url: "/admin/ajax_booking.php",
                            type: "GET",
                            data: {
                                type: "price",
                                dateStart: dateStart,
                                price: newPrice,
                                dateEnd: dateEnd,
                                roomNum: roomNum,
                                discount: discount,
                                guestsNum: guestsNum

                            },
                          success: function(data){
                            $('#total_price').text(data + " руб.");
                            $('#total_price_input').val(data);
                            $('.price_box').removeClass('hidden');
                          }
                        });
                    }
                    else {
                        $.ajax({
                            url: "/admin/ajax_booking.php",
                            type: "GET",
                            data: {
                                type: "price",
                                dateStart: dateStart,
                                dateEnd: dateEnd,
                                roomNum: roomNum,
                                discount: discount,
                                guestsNum: guestsNum

                            },
                          success: function(data){
                            $('#total_price').text(data + " руб.");
                            $('#total_price_input').val(data);
                            $('.price_box').removeClass('hidden');
                          }
                        });
                    };
//        }
                    
    }
        function ajaxPrice(){
                     var dateStart = $('#dateStart').val();
                    var dateEnd = $('#dateEnd').val();
                    var roomNum = $('#roomNum').val();
                    var discount = $('#discount').val();
                    var guestsNum = $('#guestsNum').val();
                    var newPrice = $('#edit_price').val();
                    if(newPrice.length > 1) {
                        $.ajax({
                            url: "/admin/ajax_booking.php",
                            type: "GET",
                            data: {
                                type: "price",
                                price_night: "price",
                                price: newPrice,
                                dateStart: dateStart,
                                dateEnd: dateEnd,
                                roomNum: roomNum,
                                discount: discount,
                                guestsNum: guestsNum

                            },
                          success: function(data){
                            $('#night_price').text(data + " руб.");
                          }
                        });
                        
                    }
                    else {
                        $.ajax({
                            url: "/admin/ajax_booking.php",
                            type: "GET",
                            data: {
                                type: "price",
                                price_night: "price",
                                dateStart: dateStart,
                                dateEnd: dateEnd,
                                roomNum: roomNum,
                                discount: discount,
                                guestsNum: guestsNum

                            },
                          success: function(data){
                            $('#night_price').text(data + " руб.");
                            $('#auto_price').val(data);
                          }
                        });
                    };
                    
        }   
        function isFree(){
            var dateStart = $('#dateStart').val();
            var dateEnd = $('#dateEnd').val();
            var roomNum = $('#roomNum').val();
            $.ajax({
                    url: "/admin/ajax_booking.php",
                    type: "GET",
                    data: {
                        type: "checkIsFree",
                        dateStart: dateStart,
                        dateEnd: dateEnd,
                        roomNum: roomNum
                    },
                  success: function(data){
                      var check = parseInt(data);
                      if(check  == 0){
                          $('.cant_add').removeClass('hidden');
                          $('.add_booking').prop('disabled', true);
                      }
                      else{
                        $('.cant_add').addClass('hidden');
                        $('.add_booking').prop('disabled', false);
                      }
                  }
            });
        }
        $('#dateStart, #dateEnd, #roomNum').change(function(){
            var dateStart = $('#dateStart').val();
            var dateEnd = $('#dateEnd').val();
            if(dateStart != "" && dateEnd != ""){
                var check = isFree();
        }
        });
        var guestsNum = new ajaxGuestsNum();
        $('#roomNum').change(function(){
            $('#guestsNum').val(1);
             var guests = new ajaxGuestsNum();
             var total = new ajaxTotal();
             var price = new ajaxPrice();
        });
        $('.datepicker-here').click(function(){
            var myDatepicker = $(this).datepicker().data('datepicker');
            myDatepicker.show();
        });
        $('#dateStart, #dateEnd').focusout(function(){
            if($('#dateStart').val() != "" && $('#dateStart').val().length == 10 && $('#dateEnd').val() != ""){
                 var total = new ajaxTotal();
                 var price = new ajaxPrice();
            }
        });
        $('select, #guestName, #guestPhone, #discount, #breakfast, #genious, #booker').click(function(){ 
             var total = new ajaxTotal();
             var price = new ajaxPrice();
        });
        $('#guestName').keyup(function(){
            var total = new ajaxTotal();
            var price = new ajaxPrice();
        });
        $('#edit_price').change(function(){
            var total = new ajaxTotal();
            var price = new ajaxPrice();
        });
        $('#total_price').click(function(){
            $('#total_price').addClass('hidden');
            $('#total_price_input').removeClass('hidden');
        });        
        $('#night_price').click(function(){
            var price = $('#night_price').text();
            price = price.substring(0,price.length - 5);
            $('#edit_price').val(price);
            $('#night_price').addClass('hidden');
            $('#edit_price').removeClass('hidden');
            
        });
        $('.layout, .close, .cancel').click(function(){
                $('.layout').addClass('hidden');
                $('.modal_booking').addClass('hidden');
                $('.show_booked').addClass('hidden');
            });
    });
    
</script>

