<?php 
    include("header.php");
?>
<div class="show_booked">
</div>
<div class="modal_confirm">
</div>
<div class="modal_booking hidden">
</div>
<?php echo $_SERVER['PHP_SELF']; 
?>
    <div class="container-fluid">
        <div class="container today_info">
            <h4>Сегодня, <?php echo date("d.m.Y"); ?></h4>
            <div class="col-md-6">
                <?php 
                    todayInfo();
                ?>
            </div>  
            <div class="col-md-6">
                   <?php getPrePayGuests(); ?>
            </div>
            
        </div>
        <form class="table-control form col-md-6" action="#" method="get">    
            <div class="form-group col-md-4">
                <label for="date">Дата начала:</label>
                <input type="text" id="date" name="date" class="form-control datepicker-here" value="<?php echo date_format(date_create($date), "d.m.Y"); ?>">
            </div>
            <div class="form-group col-md-3">
                <label for="period">Период : </label>
                <select required class="form-control col-md-5" id="period" name="period">
                    <?php 
                        foreach($periods as $key => $value){
                    ?>
                <option <?php echo "value={$key}";?>>
                    <?php 
                        echo $value;
                    ?>
                </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label style="visibility:hidden;"> dkl;fdk   </label>
                <input type="submit" class="form-control btn btn-success" name="submit_period" value="OK">
            </div>
        </form>
        <form name="form_search" method="post" action="search.php" class="form col-md-4">
                <label>Поиск бронирования</label>
            <div class="form-group col-md-8">
                <input type="text" class="form-control" name="input_search" placeholder="Введите имя гостя..">
            </div>
            <div class="form-group col-md-4">
                <button name="submit_search" class="form-control btn btn-warning search_btn">Искать</button>
            </div>
        </form>
        <label style="visibility:hidden;"> dkl;fdk   </label>
        <button id="add_booking" class="btn btn-info col-md-2">
            Добавить Бронирование
        </button>
        <table class="table table-bordered booking_table">
            <thead>
                <tr>
                    <td>Номер</td>
                    <?php
                        tableRoom();
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $dates = dataCount($date, $period);
                    $booking = makeDateArray($date, $period, "dateStart");
                    tableFill($dates, $booking);
                ?>
            </tbody>
        </table>
    </div>
        <script>
        $(document).ready(function(){
            $('.free').click(function(){
                var roomNum = $(this).prop("id");
                var date = $(this).prop("title");
                 $.ajax({
                      url: "modals/modal_add_booking.php",
                      type: "GET",
                      data: {
                        date: date,
                        roomNum: roomNum
                      },
                      success: function(data){
                        $('.modal_booking').html(data);
                        $('.modal_booking').removeClass('hidden');
                        $('.layout').removeClass('hidden');
                      }
                    });
            });
            $("button[name='action']").click(function(){
                var action = $(this).prop("value");
                var id = $('#id').text();
                if(action =='delete' || action == 'cancel'){
                    if(action =='delete'){
                        var modalText = "удаление";
                    }
                    else {
                        var modalText = "отмену";
                    }
                    var agree = confirm("Подтвердите " + modalText + " бронирования");
                }
               if(agree){
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
            $('.checkIn').click(function(){
                var id = $(this).attr('id');
                var action = "checkIn";
                $.ajax({
                      url: "actions.php",
                      type: "GET",
                      data: {
                        action: action,
                        id: id
                      },
                      success: function(data){
//                                prompt(data);
                            $('.modal_confirm, .layout').removeClass('hidden');
                            $('.modal_confirm').html(data);
                        }
                });
            });
            $('.pre-pay').click(function(){
                var id = $(this).attr('title');
                var action = "pre_pay";
                $.ajax({
                      url: "actions.php",
                      type: "GET",
                      data: {
                        action: action,
                        id: id
                      },
                      success: function(data){
//                                prompt(data);
                            $('.modal_confirm, .layout').removeClass('hidden');
                            $('.modal_confirm').html(data);
                        }
                });
            });
               $('.btn-deposit').click(function(){
                var id = $(this).attr('id');
                var action = "returnDeposit";
                var name = $(this).prop("value");
                $.ajax({
                      url: "actions.php",
                      type: "GET",
                      data: {
                        action: action,
                        id: id,
                        name: name
                      },
                      success: function(data){
//                                prompt(data);
                            window.location = window.location.pathname;
                        }
                });
            });
            $('#add_booking').click(function(){
                 $.ajax({
                            url: "modals/modal_add_booking.php",
                            type: "GET",
                            data: {
                                type: "add"
                            },
                            success: function(data){
                                $('.modal_booking').html(data);
                                $('.modal_booking').removeClass('hidden');
                                $('.layout').removeClass('hidden');
                                $('#query_type').val("insert");
                          }
                        });                
            });
            $('.booked, .booked_pole').click(function(){
                var id = $(this).attr("title");
                var url = $('.redirect').text() + id;
                $(location).attr('href',url);
            });
            $('.layout, .close, .cancel').click(function(){
                $('.layout').addClass('hidden');
                $('.modal_booking').addClass('hidden');
                $('.show_booked').addClass('hidden');
                $('.modal_confirm').addClass('hidden');
            });
        });
    </script>
</body>
</html>
