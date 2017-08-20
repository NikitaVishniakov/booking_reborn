/**
 * Created by vishniakov on 30.07.17.
 */
$('#night_price, #total_price_val').keyup(function () {
    var id = $('#bookingId').val();
    var total = $('#total_price_val').val();
    var price = $('#night_price').val();
    var action = $(this).prop('id');
    $.ajax({
        url: "/admin/booking_page/countTotalPrice/",
        type: "GET",
        data: {
            id: id,
            total: total,
            price: price,
            action: action
        },
        success: function(data) {
            if(action == 'night_price'){
                $('#total-price-text').text(data);
                $('#total_price_val').val(data);
            }
            else{
                $('#night_price_text').text(data);
                $('#night_price').val(data);
            }
        }
    })
});

$('.confirm-price').click(function () {
    var action = $(this).prop('id');
    var total = $('#total_price_val').val();
    var price = $('#night_price').val();
    var id = $('#bookingId').val();
    $.ajax({
        url: "/admin/booking_page/changeTotalPrice",
        type: "GET",
        data: {
            id: id,
            total: total,
            price: price
        },
        success: function(data) {
            $('.price-form').addClass('hidden');
            $('.booking-total-amount').removeClass('hidden');
            $('#night_price_text').text(price);
            $('#total-price-text').text(total);

        }
    });
});

$('.booking-total-amount').click(function () {
    $(this).next().removeClass('hidden');
    $(this).next().find('input[type="text"]').focus();
    $(this).addClass('hidden')
});

// $('.edit-price').focusout(function () {
//     $(this).val($(this).parent().parent().find('.price-val').text());
// });

$('.edit-prices').click(function () {
    $('.cost .view').addClass('hidden');
    $('.cost .input').removeClass('hidden');
    $('.edit-prices').addClass('hidden');
    $('.save-changes').removeClass('hidden');
});
