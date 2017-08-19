<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 09.07.17
 * Time: 23:45
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Добавление брони</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<form method="POST" action="/admin/booking_table/add_booking" autocomplete="off">
<input type="hidden" id="guest-id" name="guest_id">
<div class="modal-content form-horizontal add-booking-form">
        <div class="row">
            <div class="half-len">
        <div class="row">
            <div class="label">
                <label class="">Бронировал:</label>
            </div>
            <div class="has-tooltip input-wrapper">
                <input required class="input booker-name" name="booker" type="text" placeholder="Введите ФИО человека, внесшего бронь">
                <div class="tooltip">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Дата въезда:</label>
                </div>
                <div class="input-wrapper">
                    <i class="date-pad fa fa-calendar" aria-hidden="true"></i>
                    <input required id="dateStart" class="input date-input cost-name datepicker-here" value="<?=$dateStart?>" name="dateStart">
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Дата выезда:</label>
                </div>
                <div class="input-wrapper">
                    <i class="date-pad fa fa-calendar" aria-hidden="true"></i>
                    <input id="dateEnd" class="input date-input cost-name datepicker-here" name="dateEnd" type="text">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Категория номера:</label>
                </div>
                <div class="input-wrapper">
                    <select id="roomCat" class="input select" name="roomCat" type="text">
                        <option value="1">Стандарт</option>
                        <option value="2">Улучшенный</option>
                    </select>
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Выберите номер:</label>
                </div>
                <div class="input-wrapper">
                    <select id="roomNum" class="input select" name="roomNum" type="text">
                        <option selected value="1">Стандарт 1</option>
                        <option value="3">Стандарт 3</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Выберите количество гостей:</label>
                </div>
                <div class="input-wrapper">
                    <select id="guestsNum" class="input select" name="guestsNum" type="text">
                    </select>
                </div>
            </div>
            <div class="half-len">
                <div class="checkboxes">
                    <label for="breakfast" class="">Завтрак <input id="breakfast" name="breakfast" type="checkbox">
                    </label>
                    <label for="specialGuest" class="">Особый статус <input id="specialGuest" name="Genious" type="checkbox">
                    </label>
                </div>
            </div>
        </div>
    </div>
            <div class="half-len border-left">
                    <div class="row">
                        <div class="half-len">
                            <div class="label">
                                <label class="">ФИО постояльца:</label>
                            </div>
                            <div class="input-wrapper">
                                <input id="guest-fio" name="guestName" class="input" type="text">
                            </div>
                        </div>
                        <div class="half-len">
                            <div class="label">
                                <label class="">Телефон:</label>
                            </div>
                            <div class="input-wrapper">
                                <input id="guest-phone" name="guestPhone" class="input" type="text">
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="half-len">
                        <div class="label">
                            <label class="">Способ оплаты:</label>
                        </div>
                        <div class="input-wrapper">
                            <select name="payment" id="payment-type" class="input select">
                                <?=selectPaymentTypeBooking();?>
                            </select>
                        </div>
                    </div>
                    <div class="half-len">
                        <div class="label">
                            <label class="">Источник брони:</label>
                        </div>
                        <div class="input-wrapper">
                            <select name="source" id="payment-type" class="input select">
                                <?=$sources?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="half-len no-padding">
                        <div class="row">
                            <div class="label">
                                <label class="">Скидка (%):</label>
                            </div>
                            <div class="input-wrapper">
                                <input id="discount" name="discount" class="input" type="number">
                            </div>
                        </div>
                        <div class="row">
                            <div class="label">
                                <label class="">Комментарий:</label>
                            </div>
                            <div class="input-wrapper">
                                <textarea name="comment" class="input textarea"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="half-len booking-price">
                        <div class="price-header">
                            Стоимость проживания(общая):
                        </div>
                        <div class="booking-total"><span id="total_price_text" class="price-total">0</span> руб.</div>
                           <div class="price-form hidden">
                            <input name="amount" type="text" id="total_price_val" class="input edit-price " value="0">
                            <a id="total_price" class="btn btn-small btn-green confirm-price-btn">ок</a>
                           </div>
                        <div class="price-header">
                            Цена за сутки:
                        </div>
                        <div class="booking-total"><span id="night_price_text" class="price-value">0</span> руб.</div>
                        <div class="price-form hidden">
                            <input name="price" type="text" class="input edit-price " id="night_price_val" value="0">
                            <a id="night_price" class="btn btn-small btn-green confirm-price-btn">ок</a>
                        </div>
                        <div class="second-price-wrapper hidden">
                            <div class="price-header second-price-header">
                                Цена за сутки:
                                <span class="second-price-date"></span>
                            </div>
                            <div class="booking-total" id="second-price"><span id="second_night_price_text" class="price-value">0</span> руб.</div>
                            <div class="price-form hidden">
                                <input name="second_price" type="text" class="input edit-price " id="second_night_price_val" value="">
                                <input name="second_price_start" type="hidden" class="input edit-price " id="second_night_price_start_val" value="">
                                <a id="second_night_price" class="btn btn-small btn-green confirm-price-btn">ок</a>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div
</div>
<div class="modal-footer">
    <div id="cancel" class="btn btn-big btn-default">Отмена</div>
    <input  type="submit" id="submit_booking" name="add_booking" class="btn btn-big btn-green" value="Сохранить"/>
</div>
</form>
