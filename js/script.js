/**
 * Created by vishniakov on 28.06.17.
 */
$(document).ready(function(){

    //Блок работы с меню

    //открываем мобильное меню
    $('.mobile-open').click(function () {
        $('.menu').toggle();
        $('.menu').toggleClass('menu-hidden');
        $('.mobile-open .burger-wrapper').toggleClass('open');
    });

    //клик вне области меню - скрываем
    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $('.menu'); // тут указываем ID элемента
        var menu = $('.mobile-open');
        if($(window).width() < 1030) {
            if (!div.is(e.target) && !menu.is(e.target) // если клик был не по нашему блоку
                && div.has(e.target).length === 0) { // и не по его дочерним элементам
                $('.menu').hide();
                $('.menu').addClass('menu-hidden');
                $('.mobile-open .burger-wrapper').removeClass('open');
            }
        }
    });

    //отображение мобильного меню только при разрешении менее 1030рх
    if($(window).width() < 1030) {
        $('.menu').addClass('menu-hidden');
    }


    //Расчет размера колонок в таблице бронирования

    //Инициализация таблицы
    var tableWidth = $('.booking-table-container').width()*0.125;
    $('.table-cell').width(tableWidth - 1);
    $('.rooms-block').width(tableWidth);
    $('.bookings').css({"margin-left":tableWidth});
    $('.booking-cell').width(tableWidth - 2);


    //Изменение размера при ресайзе
    $(window).resize(function() {
        var tableWidth = $('.booking-table-container').width()*0.125;
        $('.table-cell').width(tableWidth - 1);
        $('.rooms-block').width(tableWidth);
        $('.bookings').css({"margin-left":tableWidth});
        $('.booking-cell').width(tableWidth - 2);
        if($(window).width() > 1030){
            $('.menu').removeClass('menu-hidden');
            $('.mobile-open .burger-wrapper').addClass('open');
        }
        else{
            $('.menu').addClass('menu-hidden');
            $('.mobile-open .burger-wrapper').removeClass('open');
        }
    });


    //Блок пользователя
    //Клик по имени - открываем менюшку
    $('.user-name').click(function () {
        $('.user-menu').toggle();
    })
    //Клик по меню - скрываем его
    $('.user-menu').click(function () {
        $('.user-menu').addClass('menu-hidden');
    })



    //Воспомогательные функции для работы с модальными окнами
    function layout_close() {
        $('.layout').hide();
    }

    function layout_small() {
        $('.layout-small').show();
    }

    function layout_small_close() {
        $('.layout-small').hide();
    }

    //Открыть/закрыть маленькое модальное окно
    function modal_small_open() {
        $('.modal-small').show();
        var left = ($(window).width() - $('.modal-small').width()) / 2;
        $('.modal-small').css({'left': + left + 'px'});
        layout_small();
    }
    function modal_small_close() {
        $('.modal-small').hide();
        $('.modal-small').removeClass('modal-confirm');
    }



    function modal_close() {
        $('.modal').hide();
        layout_close();
    }

    $('.layout').click(function () {
        layout_close();
        modal_close();
    });
    $('.modal').on('click', '.modal-close', function () {
        layout_close();
        modal_close();
    });
    $('.modal').on('click', '#cancel' ,function () {
        layout_close();
        modal_close();
    });

    $('.Cashdesk-header').click(function () {
        $(this).parent().toggleClass('class');
    });


    $('.call-modal').click(function(){
       var modal =  $(this).attr('id');
        $.ajax({
            url: "/templates/modals/modal_" + modal + ".php",
            type: 'GET',
            success: function(data){
                modal_open();
                $('.modal').html(data);
            }
        });
    });


    $('.has-children').click(function () {
        $(this).next().toggleClass('opened');
        $(this).toggleClass('hide');
    })


    $('.costs-form').submit(function(){
        var parent_val = $('#cost-category').val();
        var quantity = $('#cost-quantity').val();
        var units = $('#costs-units').val()
        var error = false;
        if(parent_val == ''){
            $('#cost-category').addClass('error-input');
            $('#cost-category-label').addClass('red');
            error = true;
        }
        else{
            $('#cost-category').removeClass('error-input');
            $('#cost-category-label').removeClass('red');
        }
        if(quantity != ''){
            if(units == ''){
                $('#costs-units').addClass('error-input');
                $('#cost-units-label').addClass('red');
                error = true;
            }
            else{
                $('#costs-units').removeClass('error-input');
                $('#cost-units-label').removeClass('red');
            }
        }

        if(error){
            return false;
        }
    });


    $('.cost-item').click(function(){
        modal_open();
        layout();
    });

    $('.modal').on('click', '.tooltip-row', function () {
        $('.booker-name').val($(this).find('.guest-name').text());
        $('#guest-phone').val($(this).find('.guest-phone').text());
        $('#guest-id').val($(this).attr('data-id'));
        $('.booker-name').removeClass('tooltip-open');
        $('.tooltip').hide();
    });

    //Тугл блоков в издержках
    $('div.category').click(function(){
        $(this).next().toggle("slow");
    });
    $('.layout-small').click(function () {
        layout_small_close();
        modal_small_close();
    })
    $('.modal-small').on('click', '#cancel' ,function () {
        layout_small_close();
        modal_small_close();
    });
    $('.modal-small').on('click', '.modal-close' ,function () {
        layout_small_close();
        modal_small_close();
    });
    $('#booking-actions').click(function () {
        $('.actions-menu').toggle();
    });

    $('#edit_info').click(function () {
        $('.edit').toggleClass('hidden');
        $('.view').toggleClass('hidden');
    });

    $('#cancel_edit').click(function () {
        $('.edit').toggleClass('hidden');
        $('.view').toggleClass('hidden');
    });

    $('.textarea').on('change keyup paste',function () {
        $('#save_comment').removeClass('hidden');
    });

    $('.modal').on('click', '.booking-total', function () {
        $(this).next().removeClass('hidden');
        $(this).next().find('input[type="text"]').focus();
        $(this).addClass('hidden')
    });

    $('#month-select').change(function () {
        var month = $(this).val()
        var data = $(this).data();
        var year = $('#year-select').val();
        $.ajax({
            url: '/admin/' + data.action,
            type: 'GET',
            data: {
                month: month,
                year: year,
                ajax: 'Y'
            },
            success: function (data) {
                $('.main-container').replaceWith(data);
            }
        })
    });
    $('#year-select').change(function () {
        var month = $('#month-select').val()
        var data = $('#month-select').data();
        var year = $(this).val();
        $.ajax({
            url: '/admin/' + data.action,
            type: 'GET',
            data: {
                month: month,
                year: year,
                ajax: 'Y'
            },
            success: function (data) {
                $('.main-container').replaceWith(data);
            }
        })
    });

    $('.modal').on('change', '#prolongation_hours', function () {
        var price = $('#prolongation_hour_cost').val();
        var hoursStart = $('#hours_start').text();
        var hoursEnd = $('#prolongation_hours').val();
        $.ajax({
            url: "/admin/booking_page/addProlongationHours",
            type: "GET",
            data: {
                AJAX: 'Y',
                hoursStart: hoursStart,
                hoursEnd: hoursEnd,
                price: price
            },
            success: function (data) {
                $('#prolongation_hour_quantity').val(data.hours);
                $('#prolongation_hour_total').val(data.price);
            }
        })
    });
    $('.modal').on('keyup', '#prolongation_hour_cost', function () {
        var price = $('#prolongation_hour_cost').val();
        var hoursStart = $('#hours_start').text();
        var hoursEnd = $('#prolongation_hours').val();
        $.ajax({
            url: "/admin/booking_page/addProlongationHours",
            type: "GET",
            data: {
                AJAX: 'Y',
                hoursStart: hoursStart,
                hoursEnd: hoursEnd,
                price: price
            },
            success: function (data) {
                $('#prolongation_hour_quantity').val(data.hours);
                $('#prolongation_hour_total').val(data.price);
            }
        })
    });

    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $(".price-form"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            $('.price-form').addClass('hidden');
            $('.booking-total-amount').removeClass('hidden');
        }
    });


    //Инициализация модального окна
    /* устанавливаем на кнопку класс  .btn  или btn-modal (если не хотим придавать ей вид кнопки)
     ** ставим атрибут data-modal[modal || modal_small]
     ** ставим аттрибут data-action - название экшна к которому мы обратимся
     ** опционально - data-id - передаем необходимый id
     **
     */    $('.modal, body').on('click', '.btn, .btn-modal', function (event) {
        var data = $(this).data();
        if(data.modal) {
            if (data.modal == 'modal') {
                if (!data.id) {
                    data.id = '';
                }
                event.preventDefault();
                $.ajax({
                    url: '/admin/modal/' + data.action + '/' + data.id,
                    success: function (data) {
                        $('.modal').html(data);
                        modal_open();
                    }
                })
            }
            if (data.modal == 'modal-small') {
                if (!data.id) {
                    data.id = '';
                }
                event.preventDefault();
                $.ajax({
                    url: '/admin/modal/' + data.action + '/' + data.id,
                    success: function (data) {
                        $('.modal-small').html(data);
                        modal_small_open()
                    }
                })
            }
        }
    });


    //Вызов модалки подверждения
    $('.modal, body').on('click', '.need-confirm', function () {
        var data = $(this).data();
        if (data.action) {
            event.preventDefault();
            $.ajax({
                url: "/templates/modals/modal_confirm.php",
                type: "GET",
                data: {
                    ACTION: data.action,
                    ID: data.id
                },
                success: function(data){
                    $('.modal-small').html(data);
                }
            });
            $('.modal-small').addClass('modal-confirm');
            modal_small_open();
        }
    });

    //Добавление нового тарифа
    $('.add_rate').click(function () {

    });


    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $(".price-form"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            $('.price-form').addClass('hidden');
            $('.booking-total').removeClass('hidden');
        }
    });

    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $(".different-price-block"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            $('.different-price-block').addClass('hidden');
        }
    });

    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $(".actions-menu, #booking-actions"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            $('.actions-menu').addClass('hidden');
        }
        else{
            $('.actions-menu').removeClass('hidden');
        }
    });

    $('.booking-total').click(function () {
        $('.different-price-block').toggleClass('hidden');
    });


    $('.modal').on('change', '#cost-category', function () {
        var category = $(this).val();
        $.ajax({
            url: "/admin/finance/ajaxSubCat",
            type: 'GET',
            data: {
                category: category
            },
            success: function(data){
                $('#cost-sub-category').html(data);
            }
        });
    });

    $('.modal').on('click', '#add_cat', function () {
        $.ajax({
            url: "/templates/modals/modal_add_cost_category.php",
            type: "GET",
            data: {
            },
            success: function(data){
                modal_small_open();
                layout_small();
                $('.modal-small').html(data);
            }
        });
    });
    $('.modal').on('click', '#add_subcat', function () {
        $.ajax({
            url: "/templates/modals/modal_add_cost_subcategory.php",
            type: "GET",
            data: {
            },
            success: function(data){
                modal_small_open();
                layout_small();
                $('.modal-small').html(data);
            }
        });
    });
    $('#add_cost').click(function(){
        $.ajax({
            url: "/templates/modals/modal_add_cost.php",
            type: "GET",
            data: {
            },
            success: function(data){
                modal_open();
                $('.modal').html(data);
            }
        });
    });
    $('.cost-item').click(function(){
        var id = $(this).attr('id');
        $.ajax({
            url: "/templates/modals/modal_edit_cost.php",
            type: "GET",
            data: {
            },
            success: function(data){
                modal_open();
                $('.modal').html(data);
            }
        });
    });
    $('#add_payment').click(function () {
        $.ajax({
            url: "/templates/modals/modal_add_payment.php",
            type: "GET",
            data: {
            },
            success: function(data){
                modal_open();
                $('.modal').html(data);
            }
        });
    })
})