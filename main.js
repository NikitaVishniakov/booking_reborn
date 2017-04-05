 $(document).ready(function() {
      function ajaxGuestsNum(){
        var roomNum = $('#roomNum').val();
        $.ajax({
                      url: "ajax_booking.php",
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
    function changeDate(){
        $('#start_day, #start_month').change(function(){
            var day = $('#start_day').val();
            var month = $('#start_month').val();
            if(day != 31){
                day = parseInt(day) + 1;
            }
            else{
                day = 1;
                if(month == '12'){
                    month = 1;
                }
                else {
                    month = parseInt(month)+1;
                }
                $('#end_month').val(month);
            }
            $('#end_day').val(day);
            $('#end_month').val(month);
        });
//        $('#start_month').change(function(){
//            var day = $('#start_month').val();
//            day = parseInt(day);
//            $('#end_month').val(day);
//        });
    }
     
    function ajaxTotal(){
                    var date = $('#start_day').val();
                    var month = $('#start_month').val();
                    var date_end = $('#end_day').val();
                    var month_end = $('#end_month').val();
                    var roomNum = $('#roomNum').val();
                    var discount = $('#discount').val();
                    var guestsNum = $('#guestsNum').val();
                    var newPrice = $('#edit_price').val();
//         prompt(guestsNum);
//                    if(discount.length == 0){
//                        discount = 0;
//                    }
//                    else {
//                    $('#discount').val();
//                    }
//        if( $('.query_type').val() == "insert"){
                    if(date.length < 2) {
                        date = "0" + date;
                    }
                    if(month.length < 2) {
                        month = "0" + month;
                    }
                    if(date_end.length < 2) {
                        date_end = "0" + date_end;
                    }
                    if(month_end.length < 2) {
                        month_end = "0" + month_end;
                    }
                    date = month + "-" + date;
                    date_end = month_end + "-" + date_end;
                    if(newPrice.length > 1) {
                         $.ajax({
                            url: "ajax_booking.php",
                            type: "GET",
                            data: {
                                type: "price",
                                date: date,
                                price: newPrice,
                                date_end: date_end,
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
                            url: "ajax_booking.php",
                            type: "GET",
                            data: {
                                type: "price",
                                date: date,
                                date_end: date_end,
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
                    var date = $('#start_day').val();
                    var month = $('#start_month').val();
                    var date_end = $('#end_day').val();
                    var month_end = $('#end_month').val();
                    var roomNum = $('#roomNum').val();
                    var discount = $('#discount').val();
                    var guestsNum = $('#guestsNum').val();
                    var newPrice = $('#edit_price').val();
//         prompt(guestsNum);
//                    if(discount.length == 0){
//                        discount = 0;
//                    }
//                    else {
//                    $('#discount').val();
//                    }
                    if(date.length < 2) {
                        date = "0" + date;
                    }
                    if(month.length < 2) {
                        month = "0" + month;
                    }
                    if(date_end.length < 2) {
                        date_end = "0" + date_end;
                    }
                    if(month_end.length < 2) {
                        month_end = "0" + month_end;
                    }
                    date = month + "-" + date;
                    date_end = month_end + "-" + date_end; 
                    if(newPrice.length > 1) {
                        $.ajax({
                            url: "ajax_booking.php",
                            type: "GET",
                            data: {
                                type: "price",
                                price_night: "price",
                                price: newPrice,
                                date: date,
                                date_end: date_end,
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
                            url: "ajax_booking.php",
                            type: "GET",
                            data: {
                                type: "price",
                                price_night: "price",
                                date: date,
                                date_end: date_end,
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
 });
