/**
 * Created by vishniakov on 11.07.17.
 */
function guestNum(id) {
    $.ajax({
        url: "/admin/booking_table/ajax_booking",
        type: 'GET',
        data: {
            type: 'guestsNum',
            roomNum: id
        },
        success: function(data){
            $('#guestsNum').html(data);
        }
    });
}
function roomCategory(category) {
    $.ajax({
        url: "/admin/booking_table/ajax_booking",
        type: 'GET',
        data: {
            type: 'category',
            category: category
        },
        success: function(data){
            $('#roomCat').html(data);
        }
    });
}
function roomNum(category, chosen) {
    if (chosen === undefined) {
        chosen = 1;
    }
    $.ajax({
        url: "/admin/booking_table/ajax_booking",
        type: 'GET',
        data: {
            type: 'rooms',
            chosen: chosen,
            category: category
        },
        success: function(data){
            $('#roomNum').html(data);
        }
    });
}
function isFree() {
    var dateStart = $('#dateStart').val();
    var dateEnd = $('#dateEnd').val();
    var room = $('#roomNum').val();
    var booking_id = $('#bookingId').val();
    var arrData = {
        AJAX: 'Y',
        dateStart: dateStart,
        dateEnd: dateEnd,
        room: room
    };
    if(booking_id != undefined){
        arrData.booking_id = booking_id;
    }
    $.ajax({
        url: "/admin/booking_table/checkAvailability",
        type: 'GET',
        data:  arrData,
        success: function (data) {
            if(data.status == 'booked'){
                alert("В выбранный вами номер ("+ room +") занят в данные даты (" + dateStart + " - " +  dateEnd + "). Пожалуйста, измените номер или даты для добавления бронирования");
                $('#submit_booking').prop('disabled',true);
            }
            else{
                $('#submit_booking').prop('disabled',false);
            }
        }
    });
}
function layout() {
    $('.layout').show();
}
function modal_open() {
    $('.modal').show();
    var left = ($(window).width() - $('.modal').width()) / 2;
    if($('.modal').prop('id')=='modal-booking'){
        var top = window.pageYOffset + 40;
    }
    else{
        var top = window.pageYOffset + 100;
    }
    $('.modal').css({'left': + left + 'px', 'top': + top + 'px'});
    layout();
}
function  ajaxPrice() {
    var dateStart = $('#dateStart').val();
    var dateEnd = $('#dateEnd').val();
    var roomCat = $('#roomCat').val();
    var guestsNum = $('#guestsNum').val();
    var breakfast = $('#breakfast').prop('checked') ? 1 : 0;
    var specialGuest = $('#specialGuest').prop('checked') ? 1 : 0;
    var discount = $('#discount').val();
    $.ajax({
        url: "/admin/booking_table/ajax_booking",
        type: 'GET',
        data: {
            type: 'count_price',
            dateStart : dateStart,
            dateEnd : dateEnd,
            roomCat : roomCat,
            guestsNum : guestsNum,
            breakfast : breakfast,
            specialGuest : specialGuest,
            discount: discount
        },
        success: function(data){
            var count = Object.keys(data).length;
            $('#total_price_text').html(data['total']);
            $('#night_price_text').html(data['price']);
            $('#total_price_val').val(data['total']);
            $('#night_price_val').val(data['price']);
            if(count>2) {
                $('.second-price-wrapper').removeClass('hidden');
                $('.second-price-date').html("(c " + data['price2_start'] + ")");
                $('#second_night_price_val').val(data['price2']);
                $('#second_night_price_start_val').val(data['price2_start']);
                $('#second_night_price_text').html(data['price2']);
            }
            else{
                $('.second-price-wrapper').addClass('hidden');
                $('#second_night_price_val').val('');
                $('#second_night_price_start_val').val('');
                $('.second-price-date').html('');
                $('#second_night_price_text').html('');
            }
        }
    });
}
function ajaxPriceEdit(){
        var dateStart = $('#dateStart').val();
        var dateEnd = $('#dateEnd').val();
        var price = $('.price-value').text();
        $.ajax({
            url: "/admin/booking_page/get_days_count",
            type: 'GET',
            data: {
                dateStart : dateStart,
                dateEnd : dateEnd,
                price: price
            },
            success: function(data){
                $('.price-total').html(data);
                var dataInt = data.replace(' ', '');
                $('#booking_amount').val(dataInt);
            }
        });
}

$('.modal').on('change', 'select', function () {
    if( $(this).prop('id') == 'roomCat' || $(this).prop('id') == 'roomNum'){
        $('#guestsNum').val(1);
        var room = $('#roomNum').val();
    }
    ajaxPrice();
});
$('.modal').on('keyup', '#dateStart, #dateEnd', function () {
    var str = $(this).val().substring(0, $(this).val().length - 1);
    $(this).val(str);
});
$('.modal').on('click', 'input[type="checkbox"]', function () {
    ajaxPrice();
});
$('.modal').on('keyup', '#discount', function () {
    ajaxPrice();
});

$('#cancel_edit').click(function () {

    var total = $('#total_price_val').val();
    $('.price-total').html(total);
})

$('#add_booking').click(function(){
    var modal =  $(this).attr('id');
    $.ajax({
        url: "/templates/modals/modal_" + modal + ".php",
        type: 'GET',
        success: function(data){
            $('.modal').html(data);
            $('.modal').addClass('modal-booking');
            $('.modal').addClass('modal-booking');
            $('.modal').prop('id', 'modal-booking');
            modal_open();
            var category = $('#roomCat').val();
            roomNum(category);
            var room = $('#roomNum').val();
            guestNum(room);
        }
    });
});

$('.free').click(function(){
    var data = $(this).data();
    var dateStart =  $(this).attr('data-date');
    var room =  $(this).attr('data-room');
    var category = $(this).attr('data-category');
    $.ajax({
        url: '/admin/modal/' + data.action,
        type: 'GET',
        data: {
            dateStart: dateStart
        },
        success: function(data){
            $('.modal').html(data);
            $('.modal').addClass('modal-booking');
            $('.modal').prop('id', 'modal-booking');
            modal_open();
            roomCategory(category);
            roomNum(category, room);
            guestNum(room);
            setTimeout(function(){ajaxPrice()}, 100);
        }
    });
});

$('.modal, .guest-info').on('click', '.datepicker-here', function () {
    var id = $(this).prop('id');
    var booking_id = $('#bookingId').val();
    $(this).datepicker({
        onSelect: function (formattedDate) {
            if(id == 'dateStart'){
                var dateStart = formattedDate;
                $('#dateStart').val(dateStart);
                ajaxPrice();
                var dateEnd = $('#dateEnd').val();
                if(dateEnd){
                    isFree();
                }
            }
            if(id == 'dateEnd'){
                var dateEnd = formattedDate;
                $('#dateend').val(dateEnd);
                ajaxPrice();
                isFree();
            }
        }
    }).data('datepicker').show();
});

$('.guest-info').on('click', '.datepicker-here', function () {
    var id = $(this).prop('id');
    var booking_id = $('#bookingId').val();
    $(this).datepicker({
        onSelect: function () {
                ajaxPriceEdit();
                isFree();
        }
    }).data('datepicker').show();
});

$('.modal, .guest-info').on('click', '#dateEnd', function () {
    var date = $('#dateStart').val();
    if(date){
        var arDate = date.split('.');
        date = new Date(arDate[2] + '-' + arDate[1] + '-' + arDate[0])
        date = new Date(date)
        date.setDate(date.getDate() + 1)
        $('#dateEnd').datepicker({minDate: new Date(date)});
    }
});
$('.modal, .guest-info').on('change', '#roomNum', function () {
    var room = $('#roomNum').val();
    guestNum(room);
    setTimeout(isFree(), 100);
});
$('.modal, .guest-info').on('change', '#roomCat', function () {
    var category = $('#roomCat').val();
    roomNum(category);
    setTimeout(function () {
        var room = $('#roomNum').val();
        guestNum(room);
    }, 50);
    setTimeout(function(){isFree()}, 100);


});

$('.modal').on('click', '.confirm-price-btn', function () {
    var id = $(this).attr('id');
    var dateStart = $('#dateStart').val();
    var dateEnd = $('#dateEnd').val();
    var price = $('#night_price_val').val();
    var totalPrice = $('#total_price_val').val();
    var second_price = $('#second_night_price_val').val();
    var second_price_start = $('#second_night_price_start_val').val();
    $.ajax({
        url: "/admin/booking_table/ajax_booking",
        type: 'GET',
        data: {
            type: id,
            dateStart: dateStart,
            dateEnd: dateEnd,
            price: price,
            total: totalPrice,
            second_price: second_price,
            second_price_start: second_price_start
        },
        success: function(data){
            if(id == 'night_price' || id == 'second_night_price'){
                $('#total_price_text').text(data);
                $('#night_price_text').text(price);
                $('#total_price_val').val(data);
                $('#second_night_price_text').html(second_price);
            }
            else{
                $('#total_price_text').text(totalPrice);
                $('#night_price_text').text(data);
                $('#night_price_val').val(data);
            }
            $('.price-form').addClass('hidden');
            $('.booking-total').removeClass('hidden');
        }
    });
});
$('.modal').on('keyup', '#night_price_val, #second_night_price_val', function () {
    var dateStart = $('#dateStart').val();
    var dateEnd = $('#dateEnd').val();
    var price = $('#night_price_val').val();
    var second_price = $('#second_night_price_val').val();
    var second_price_start = $('#second_night_price_start_val').val();
    $.ajax({
        url: "/admin/booking_table/ajax_booking",
        type: 'GET',
        data: {
            type: 'night_price',
            dateStart: dateStart,
            dateEnd: dateEnd,
            price: price,
            second_price: second_price,
            second_price_start: second_price_start
        },
        success: function(data){
            $('#night_price_text').text(price);
            $('#total_price_text').text(data);
            $('#total_price_val').val(data);
            $('#second_night_price_text').html(second_price);


        }
    });
});
$('.modal').on('keyup', '#total_price_val', function () {
    var dateStart = $('#dateStart').val();
    var dateEnd = $('#dateEnd').val();
    var totalPrice = $('#total_price_val').val();
    $.ajax({
        url: "/admin/booking_table/ajax_booking",
        type: 'GET',
        data: {
            type: 'total_price',
            dateStart: dateStart,
            dateEnd: dateEnd,
            total: totalPrice
        },
        success: function(data){
            $('#total_price_text').text(totalPrice);
            $('#night_price_text').text(data);
            $('#night_price_val').val(data);
        }
    });
});

$('.modal').on('keyup', '.booker-name', function () {

    var name = $('.booker-name').val();
    if(name.length > 2) {
        $.ajax({
            url: '/admin/booking_table/ajax_guest_list',
            type: 'GET',
            dataType: "json",
            data: {
                string: name
            },
            success: function (data) {
                var html = '';
                data.forEach(function (item, i, data) {
                    html = html + "<div data-id='"+ item.id + "' class='row tooltip-row'><span class='guest-name'>" + item.booker +"</span><span class='guest-phone'>"+ item.guestPhone +"</span> </div>";
                })
                $('.tooltip').html(html);
                $('.tooltip').show();
                $('.booker-name').addClass('tooltip-open');
            },
            error: function () {
                html = '';
                $('.tooltip').html(html);
                $('.tooltip').hide();
                $('.booker-name').removeClass('tooltip-open');
            }
        })
    }
    else{
        $('.tooltip').hide();
        $('.booker-name').removeClass('tooltip-open');
    }
});
$(document).mouseup(function (e){ // событие клика по веб-документу
    var div = $(".has-tooltip"); // тут указываем ID элемента
    if (!div.is(e.target) // если клик был не по нашему блоку
        && div.has(e.target).length === 0) { // и не по его дочерним элементам
        $('.tooltip').hide();
        $('.booker-name').removeClass('tooltip-open');
    }
});
