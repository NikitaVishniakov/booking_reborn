<!DOCTYPE html>
<html lang="RU">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="description" content="Мини-отель в центре Петербурга на улице Пушкинская 9">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/public/pics/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700|Open+Sans" rel="stylesheet">
    <script src="/libs/jquery/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/libs/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/libs/slick/slick-theme.css"/>


    <title>Мини отель Welcome | Санкт-Петербург</title>
</head>

<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-99020708-1', 'auto');
    ga('send', 'pageview');

</script>
<div class="layout-global hidden"></div>
<div class="container main">
    <header>
        <div class="header-wrapper">
            <div class="logo float-left">
                <a href="#carousel"><img id="logo" src="/public/pics/logotip.png"></a>
            </div>
            <div class="contacts-top float-right text-center">
                <div class="top-panel float-left adress">
                    <address class="bold text-icon"><span class="icon icon-location"></span> Санкт-Петербург <br> ул. Пушкинская 9</address>

                </div>
                <div class="top-panel float-left phones">
                    <p class="bold text-icon"><span class="icon icon-phone"></span> +7 (812) 314-18-55</p>
                    <p class="bold text-icon"><span class="icon icon-phone"></span> +7 (911) 008-63-89</p>
                </div>
                <div class="top-panel float-left mail">
                    <p class="bold text-icon"><span class="icon icon-mail"></span>  hotel-welcome@yandex.ru</p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </header>
    <nav class="background-choco">
        <div class="logo-mobile float-left">
            <a href="#carousel"><img id="logo" src="/public/pics/logotip.png"></a>
        </div>
        <ul class="text-center menu-desktop">
            <li><a href="#about">О нас</a></li>
            <li><a href="#rooms">Номера</a></li>
            <li><a href="#around">Что поблизости</a></li>
            <li><a href="#contacts">Контакты</a></li>
            <!--                <li><a href="#contacts">Блог</a></li>-->
        </ul>
        <a href="javascript:void(0)" class="btn-menu-mobile"><img alt="menu-mobile" src="/public/icons-mini/white-menu-icon.png"></a>
        <div class="clear"></div>
    </nav>
    <ul class="dropdown hidden">
        <li><a href="#about">О нас</a></li>
        <li><a href="#rooms">Номера</a></li>
        <li><a href="#around">Что поблизости</a></li>
        <li><a href="#contacts">Контакты</a></li>
        <!--                <li><a href="#contacts">Блог</a></li>-->
    </ul>
    <div class="content">
        <div class="slider-wrapper">
            <form class="booking-form" action="#" method="post">
                <div class="dates">
                    <div class="form-group col-md-5 col-md-offset-1">
                        <label for="startDate" class="bold label-dates">Въезд:</label>
                        <input type="date" id="startDate" class="dates-input" name="startDate">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="endDate" class="bold label-dates">Выезд:</label>
                        <input type="date" id="endDate" class="dates-input" name="endDate">
                    </div>
                </div>
                <div class="guests">
                    <label for="guestsNum" class="bold white">Количество гостей:</label>
                    <select class="guest-select" id="guestsNum" name="guestsNum">
                        <option>1</option>
                        <option>2</option>
                        <option>2+1</option>
                    </select>
                </div>
                <input type="submit" name="submit" class="btn-booking" value="Подобрать номер">
            </form>
            <div class="slider">
                <div class="slide" id="slide1">
                    <div class="layout-bg-slider">
                        <h1 class="main-header">Мини-отель Welcome <br><span class="subheader">на Пушкинской 9</span><div class="clear"></div></h1>
                    </div>
                </div>
                <div class="slide" id="slide2">
                    <div class="layout-bg-slider">
                        <p class="main-header">Континентальный завтрак <br><span class="subheader"> вкусный и сытный :)</span></p>
                    </div>
                </div>
                <div class="slide" id="slide3">
                    <div class="layout-bg-slider">
                        <p class="main-header">Лобби с  чаем, кофе и вкусностями  </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row block">
            <div id="about">
                <div class="about-wrapper">
                    <div class="additional">
                        <div class="thumpnail">
                            <img id="car" src="/public/icons-mini/sedan-icon.png">
                        </div>
                        <p class="pluses-text">Трансфер из аэропорта и обратно</p>
                    </div>
                    <div class="additional">
                        <div class="thumpnail">
                            <img id="wifi" src="/public/icons-mini/wifi.png">
                        </div>
                        <p class="pluses-text">Бесплатный Wi-Fi на всей территории отеля</p>
                    </div>
                    <div class="additional">
                        <div class="thumpnail">
                            <img id="map" src="/public/icons-mini/map-center.png">
                        </div>
                        <p class="pluses-text">Отель расположен <strong>в самом центре</strong></p>
                    </div>
                    <div class="additional">
                        <div class="thumpnail">
                            <img id="parking" src="/public/icons-mini/parking.png">
                        </div>
                        <p class="pluses-text">Бесплатный паркинг</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block" id="rooms">
            <div class="row room-header-block-main">
                <span class="brown-line"></span>
                <h2 class="header-brown">Номера</h2>
            </div>
            <div class="row room-row">
                <div class="standart-room room-block">
                    <div class="room-block-body bottom-room">
                        <div class="room-img-slider">
                            <div class="room-img" title="images-standart">
                                <img src="/public/standart/1_1.jpg">
                            </div>
                            <div class="img-row-bottom"  id="images-standart">
                                <img src="/public/standart/1_1.jpg">
                                <img src="/public/standart/1_4.jpg">
                                <img src="/public/standart/1_2.jpg">
                                <img src="/public/standart/1_3.jpg">
                            </div>
                        </div>
                        <div class="room-description">
                            <div class="room-header-block float-left">
                                <h3 class="room-header"><?=$STANDART['CATEGORY_NAME']?></h3>
                                <p class="decription-text"><?=$STANDART['ROOM_DESCRIPTION']?></p>
                            </div>
                            <div class="clear"></div>
                            <ul class="room-description-list">
                                <li><span class="icon-room icon-bed"></span> Двухспальная кровать</li>
                                <li><span class="icon-room icon-cond"></span> Кондиционер</li>
                                <li><span class="icon-room icon-tv"></span> ЖК телевизор</li>
                                <li><span class="icon-room icon-towel"></span> Полотенце</li>
                                <li><span class="icon-room icon-fen"></span> Фен</li>
                                <li><span class="icon-room icon-shower"></span> Туалет и душевая</li>
                                <li><span class="icon-room icon-toothpaste"></span> <span class="text-wide">Гигиенические принадлежности</span> </li>
                            </ul>
                        </div>
                        <div class="float-right btn-room-wrapper">
                            <a href="javascript:void(0)" class="btn-room btn-booking">Забронировать</a>
                            <div class="room-price">
                                <p>От <?=$STANDART['ROOM_PRICE']?> рублей</p>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="row room-row">
                <div class="superior-room room-block">
                    <div class="room-block-body">
                        <div class="room-img-slider">
                            <div class="room-img" title="images-superior">
                                <img src="/public/superior/pushk9_01.jpg">
                            </div>
                            <div class="img-row-bottom" id="images-superior">
                                <img src="/public/superior/pushk9_01.jpg">
                                <img src="/public/superior/pushk9_02.jpg">
                                <img src="/public/superior/pushk9_04.jpg">
                                <img src="/public/superior/pushk9_05.jpg">
                                <img src="/public/superior/pushk9_06.jpg">
                                <img src="/public/superior/pushk9_09.jpg">
                                <img src="/public/superior/pushk9_13.jpg">
                                <img src="/public/superior/pushk9_14.jpg">
                            </div>
                        </div>
                        <div class="room-description">
                            <div class="room-header-block float-left">
                                <h3 class="room-header"><?=$SUPERIOR['CATEGORY_NAME']?></h3>
                                <p class="decription-text"><?=$SUPERIOR['ROOM_DESCRIPTION']?></p>
                            </div>
                            <div class="clear"></div>
                            <ul class="room-description-list">
                                <li><span class="icon-room icon-tv"></span> Большой ЖК телевизор</li>
                                <li><span class="icon-room icon-cond"></span> Кондиционер</li>
                                <li><span class="icon-room icon-safe"></span> Сейф</li>
                                <li><span class="icon-room icon-fen"></span> Фен</li>
                                <li><span class="icon-room icon-refrige"></span> Холодильник</li>
                                <li><span class="icon-room icon-shower"></span> Туалет и душевая</li>
                                <li><span class="icon-room icon-towel"></span> Полотенце</li>
                                <li><span class="icon-room icon-bathrobe"></span> Халат</li>
                                <li><span class="icon-room icon-work"></span> <span class="text-wide">Комфортабельное рабочее место</span></li>
                                <li><span class="icon-room icon-toothpaste"></span> <span class="text-wide">Гигиенические принадлежности</span> </li>
                            </ul>
                        </div>
                        <div class="float-right btn-room-wrapper">
                            <a href="javascript:void(0)" class="btn-room btn-booking">Забронировать</a>
                            <div class="room-price">
                                <p>От <?=$SUPERIOR['ROOM_PRICE']?> рублей</p>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block" >
            <h2 class="around-header" id="around">Что рядом?</h2>
            <div class="around-slider">
                <div class="float-left around-block">
                    <div class="around-img" id="metro">
                    </div>
                    <div class="around-description metro-desc">
                        <div class="around-header-block">
                            <h4>Метро Маяковская</h4><p class="distance">400 м.</p>
                        </div>
                        <div class="around-header-block">
                            <h4>Метро Площадь Восстания</h4><p class="distance">500 м.</p>
                        </div>
                    </div>
                </div>
                <div class="float-left around-block">
                    <div class="around-img" id="galeria">
                    </div>
                    <div class="around-description">
                        <div class="around-header-block">
                            <h4>ТРК Галерея</h4><p class="distance">300 м.</p>
                        </div>
                        <p class="decs-text">Один из крупнейших и красивейших ТЦ Санкт-Петербурга</p>
                    </div>
                </div>
                <div class="float-left around-block">
                    <div class="around-img"  id="station">
                    </div>
                    <div class="around-description">
                        <div class="around-header-block">
                            <h4>Московский вокзал</h4><p class="distance">450 м.</p>
                        </div>
                        <p class="decs-text">Главный ж/д вокзал города в 5 минутах ходьбы</p>
                    </div>
                </div>
                <div class="float-left around-block">
                    <div class="around-img"  id="nevskiy">
                    </div>
                    <div class="around-description">
                        <div class="around-header-block">
                            <h4>Невский проспект</h4><p class="distance">300 м.</p>
                        </div>
                        <p class="decs-text">Главная туристическая улица города, где и происходит вся магия Петербурга</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row block" id="contacts">

        </div>
        <div class="clear"></div>
    </div>
</div>
<footer>
    <div class="maps">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A9bb5b3de47e84e72265ba09e3902699bddbe51c115c65245343647ccc5e8a708&amp;width=100%25&amp;height=100%&amp;lang=ru_RU&amp;scroll=false"></script>
    </div>
    <div class="contacts-footer">
        <div class="adres-wrapper">
            <div class="cont-adress-item">
                <p class="adress-title">
                    Адрес
                </p>
                <address>
                    г. Санкт-Петербург, ул. Пушкинская, д.9, кв. 27
                </address>
            </div>
            <div class="cont-phone-email-wrap">
                <div class="cont-phone-item">
                    <p class="phone-title">
                        Телефон
                    </p>
                    <p>
                        +7 (812) 314-18-55
                    </p>
                </div>
                <div class="cont-email-item">
                    <p class="email-title">
                        E-mail
                    </p>
                    <p>
                        <a href="mailto:hotel-welcome@yandex.ru">hotel-welcome@yandex.ru</a>
                    </p>
                </div>
            </div>
        </div>
        <form class="backlink-form" method="post" action="send_mail.php" novalidate="novalidate">
            <h3 class="backlink-header">Отправить письмо</h3>
            <div class="form-row">
                <label for="backlink-name">Имя</label>
                <input type="text" name="name" id="backlink-name" required class="backlink" placeholder="Введите ваше имя">
            </div>
            <div class="form-row">
                <label for="backlink-email">E-mail</label>
                <input type="text" name="mail" id="backlink-email" required class="backlink" placeholder="Введите ваш email">
            </div>
            <div class="form-row">
                <label for="backlink-message">Сообщение</label>
                <textarea rows="3" class="backlink" required name="message" id="backlink-message" placeholder="Введите текст вашего сообщения"></textarea>
            </div>
            <div class="form-row btn-row">
                <input type="submit" name="submit-msg" class="backlink-btn float-right" value="Отправить">
            </div>
        </form>
    </div>
    <div class="footer">
        <p>Мини-отель Welcome | 2017<br>
            Разработка сайта <a target="_blank" href="https://vk.com/nikita_vishniakov">Никита Вишняков</a></p>
    </div>
    <div class="modal-error hidden">
        <p class="modal-header">Упс! <span class="close">  x</span></p>
        <div class="modal-text">
            <p>К сожалению, бронирования через сайт по техническим причинам временно недоступны :( </p>
            <p>Свяжитесь с нами по телефону <strong>8(812) 314-18-55</strong> или отправьте письмо по электронной почте <a href="mailto:hotel-welcome@yandex.ru">hotel-welcome@yandex.ru</a>
            <p class="thanks">Спасибо за понимание! <br> Ждем вас в Welcome!</p>
        </div>
    </div>
    <div id="toTop"><img title="Наверх" alt="button_up" src="/public/icons-mini/arrow-up.png"></div>
    <div class="container-img hidden">
        <div class="close-img">X</div>
        <div class="arrow-img arrow-prev-img"> < </div>
        <div class="img-box"></div>
        <div class="arrow-img arrow-next-img"> > </div>
    </div>
</footer>
<script type="text/javascript" src="../libs/slick/slick.min.js"></script>
</body>
</html>
<script>
    $(document).ready(function(){
        var screen = $(window).height();
        screen = Math.round(0.8 * screen) + 'px';
        $('.img-box').css('height', screen);
        $(window).resize(function(){
            var screen = $(window).height();
            screen = Math.round(0.8 * screen) + 'px';
            $('.img-box').css('height', screen);
        })

        $('.arrow-next-img').click(function(){
            var current = $('.img-box img').attr('title');
            var classImg = $('.img-box img').attr('class');
            var images = $('#'+ classImg +' img').length;
            var next = parseInt(current) + 1;
            if(next >= images){
                next = 0;
            }
            var src = $('#'+ classImg +' img').eq(next).attr('src');
            $('.img-box').html('<img src="' + src + '" title="' + next + '" class="' + classImg + '">');
        });
        $('.arrow-prev-img').click(function(){
            var current = $('.img-box img').attr('title');
            var classImg = $('.img-box img').attr('class');
            var images = $('#'+ classImg +' img').length;
            var prev = parseInt(current) - 1;
            if(prev <= 0){
                prev = 3;
            }
            var src = $('#'+ classImg +' img').eq(prev).attr('src');
            $('.img-box').html('<img src="' + src + '" title="' + prev + '" class="' + classImg + '">');
        });
        $('.room-img img').click(function(){
            var src = $(this).attr('src');
            var id = $(this).parent().attr('title');
            var images = $('#'+ id +' img').length;
            $('.layout-global').removeClass('hidden');
            $('.container-img').removeClass('hidden');
            $('.close-img').removeClass('hidden');
            $('.img-box').html('<img src="' + src + '" title="1" class="' + id + '">');
        });
        $('.img-row-bottom img').click(function(){
            var src = $(this).attr('src');
            var classImg = $(this).parent().attr('id');
            var images = $('#'+ classImg +' img').length;
            var num = $(this).index();
            $('.layout-global').removeClass('hidden');
            $('.container-img').removeClass('hidden');
            $('.img-box').html('<img src="' + src + '" title="' + num + '" class="' + classImg + '">');
        });
        $('.close-img').click(function(){
            $('.container-img').addClass('hidden');
            $('.layout-global').addClass('hidden');
        });
        $('.btn-menu-mobile').click(function(){
            $('.dropdown').toggleClass('hidden');
        });
        $('.dropdown').click(function(){
            $('.dropdown').addClass('hidden');
        });
        $('.content').click(function(){
            $('.dropdown').addClass('hidden');
        });
        $('.booking-form').on('submit', function(e) {
            e.preventDefault();
            $('.modal-error').removeClass('hidden');
            $('.layout-global').removeClass('hidden');
        });
        $('.btn-booking').click(function(){
            $('.modal-error').removeClass('hidden');
            $('.layout-global').removeClass('hidden');
        });
        $('.layout-global, .close').click(function(){
            $('.modal-error').addClass('hidden');
            $('.container-img').addClass('hidden');
            $('.layout-global').addClass('hidden');
        });
        $('.slider').slick({
            dots: true,
            mobileFirst: true,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 3000,
            speed: 1200
        });
        $('.around-slider').slick({
            dots: true,
            mobileFirst: true,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 3000,
            speed: 600
        });
        $("a").click(function() {
            var elementClick = $(this).attr("href")
            var destination = $(elementClick).offset().top;
            jQuery("html:not(:animated),body:not(:animated)").animate({
                scrollTop: destination
            }, 800);
            return false;
        });
        $(function() {
            $(window).scroll(function() {
                if($(this).scrollTop() != 0) {
                    $('#toTop').fadeIn();
                }
                else {
                    $('#toTop').fadeOut();
                }
            });
            $('#toTop').click(function() {
                $('body,html').animate({scrollTop:0},800);
            });
        });
    });
</script>