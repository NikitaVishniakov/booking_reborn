
<?php if($arrResult['canceled']): ?>
<div class="canceled">Бронь отменена <a href="/admin/booking_page/reestablish_booking/<?=$arrResult['id']?>">восстановить</a> </div>
<?php endif; ?>
<div class="main-container">
    <div class="row actions-wrapper">
        <?php if(!$arrResult['isConfirmed']): ?>
        <a href="/admin/booking_page/confirm_booking/<?=$arrResult['id']?>" id="booking-confirmation" class="btn btn-small btn-green-no-bg">Подтвердить бронь</a>
        <?php else: ?>
        <span class="booking-confirmed green">Бронь подтверждена
            <?php if(!$arrResult['CAN_BE_CANCELED']): ?>
            <a href="/admin/booking_page/cancel_confirmation/<?=$arrResult['id']?>">Снять подтвержение</a>
                <?php endif; ?>
        </span>

        <?php endif; ?>
        <span id="booking-actions" class="btn btn-small btn-blue">Действия<i class="fa fa-caret-down" aria-hidden="true"></i></span>
        <div class="actions-menu">
            <?php if(!$arrResult['checkIn']):?>
                <a data-action="checkIn" data-modal="modal" data-id="<?=$arrResult['id']?>" id="checkIn" class="btn btn-big btn-green">Подтвердить заезд</a>
            <?php endif;?>
            <a href="/admin/booking_page/cancel/<?=$arrResult['id']?>" class="btn btn-big btn-yellow">Отмена брони</a>
            <a data-modal="modal" data-action="add_hour_prolongation" data-id="<?=$arrResult['id']?>?price=<?=$arrResult['price']?>" data class="btn btn-big btn-default">Почасовое продление</a>
<!--            <a data-modal="modal" data-action="add_daily_prolongation" data-id="--><?//=$arrResult['id']?><!--" data class="btn btn-big btn-default">Посуточное продление</a>-->
            <a data-modal="modal" data-action="add_return" data-id="<?=$arrResult['id']?>" class="btn btn-big btn-default">Возврат</a>
<!--            <span class="btn btn-big btn-default">Печать подтверждения</span>-->

            <?php if(isAdmin()):?>
            <a data-action="booking_page/delete" data-id="<?=$arrResult['id']?>" class="btn need-confirm btn-big btn-red">Удалить бронь</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="booking-wrap">
        <form action="/admin/booking_page/saveInfo/<?=$arrResult['id']?>" method="post" class="booking-block guest-info">
            <div class="booking-block-header">
                <h3>Информация о бронировании</h3>
                <i id="edit_info" class=" edit-icon fa fa-pencil" aria-hidden="true"></i>
                <input disabled type="hidden" id="bookingId" value="<?= $arrResult['id']?>">
                <input type="hidden" id="booking_amount" name="bookingInfo[amount]" value="<?= $arrResult['amount']?>">
            </div>
            <div class="row">
                <div class="half-len bold">
                    Бронировал:
                </div>
                <div class="half-len">
                    <span class="view"> <?= $arrResult['booker']?></span>
                    <input type="text" id="booker" name="bookingInfo[booker]" value="<?= $arrResult['booker']?>" class="input hidden edit">
                </div>
            </div>
            <div class="row">
                <div class="half-len bold">
                    Въезд:
                </div>
                <div class="half-len">
                    <span class="view"> <?= $arrResult['dateStart']?></span>
                    <div class="input-wrapper hidden edit">
                        <i class="date-pad fa fa-calendar" aria-hidden="true"></i>
                        <input id="dateStart" name="bookingInfo[dateStart]" type="text" value="<?= $arrResult['dateStart']?>" class="date-input input datepicker-here">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="half-len bold">
                    Выезд:
                </div>
                <div class="half-len">
                    <span class="view"><?= $arrResult['dateEnd']?></span>
                    <div class="input-wrapper hidden edit">
                        <i class="date-pad fa fa-calendar" aria-hidden="true"></i>
                        <input id="dateEnd" name="bookingInfo[dateEnd]" type="text" value="<?= $arrResult['dateEnd']?>" class="date-input input datepicker-here">
                    </div>
                </div>
            </div>
            <div class="view row">
                <div class="half-len bold">
                    Количество ночей:
                </div>
                <div class="half-len">
                    <span class=""> <?= $arrResult['nights']?></span>
                </div>
            </div>
            <div class="edit hidden row">
                <div class="half-len bold">
                    Категория:
                </div>
                <div class="half-len">
                    <select id="roomCat" name="bookingInfo[roomCat]" class="input" >
                        <?php selectCategory(getRoomCategory($arrResult['roomNum'])) ?>
                    </select>
                </div>
            </div>
            <div class="edit hidden row">
                <div class="half-len bold">
                    Номер:
                </div>
                <div class="half-len">
                    <select id="roomNum" name="bookingInfo[roomNum]" class="input" >
                        <?php selectRoom(getRoomCategory($arrResult['roomNum']), $arrResult['roomNum'])?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="half-len bold">
                    Количество гостей:
                </div>
                <div class="half-len">
                    <span class="view"><?= $arrResult['guestsNum']?></span>
                    <select id="guestsNum" name="bookingInfo[guestsNum]" class="input hidden edit">
                        <?php selectGuestNum($arrResult['roomNum'], $arrResult['guestsNum']); ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="half-len bold">
                    Завтрак:
                </div>
                <div class="half-len">
                    <span class="view"><?=$arrResult['has_breakfast']?></span>
                    <div class="input-wrapper hidden edit">
                        <input id="breakfast" name="bookingInfo[breakfast]" type="checkbox" <?=$arrResult['has_breakfast_checkbox']?>>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="half-len bold">
                    Имя гостя:
                </div>
                <div class="half-len">
                    <span class="view"><?= $arrResult['guestName']?></span>
                    <input id="guestName" type="text" name="bookingInfo[guestName]" value="<?= $arrResult['guestName']?>" class="input hidden edit">
                </div>
            </div>
            <div class="row">
                <div class="half-len bold">
                   Телефон:
                </div>
                <div class="half-len">
                    <span class="view"><?= $arrResult['guestPhone']?></span>
                    <input id="guestPhone" type="text" name="bookingInfo[guestPhone]" value="<?= $arrResult['guestPhone']?>" class="input hidden edit">
                </div>
            </div>
            <div class="row">
                <div class="half-len bold">
                   Способ оплаты:
                </div>
                <div class="half-len">
                    <span class="view"> <?= $arrResult['payment']?></span>
                    <select id="payment" name="bookingInfo[payment]" class="input hidden edit">
                        <?php selectPaymentTypeBooking($arrResult['payment']) ?>
                    </select>
                </div>
            </div>
            <div class="view row">
                <div class="half-len bold">
                   Добавлено:
                </div>
                <div class="half-len">
                    <span class="">  <?= $arrResult['whoAdd']?>  (<?= $arrResult['bookingDate']?>)</span>
                </div>
            </div>
            <div class="view row">
                <div class="half-len bold">
                   Источник:
                </div>
                <div class="half-len">
                    <span class=""><?= $arrResult['source']?></span>
                </div>
            </div>
            <div class="row edit hidden">
                <div class="half-len text-right">
                    <span id="cancel_edit" class="btn btn-small btn-default">Отмена</span>
                </div>
                <div class="half-len">
                    <input type="submit" id="submit_booking" name="bookingInfo[submit]" class="btn btn-small btn-green" value="Сохранить">
                </div>
            </div>
        </form>
        <div class="booking-block payment-info">
            <div class="row booking-price">
                <div class="half-len">
                    <div class="price-header">
                        Стоимость проживания(общая):
                    </div>
                    <div class="booking-total-amount"><span class="price-total price-val" id="total-price-text"><?= $arrPayment['amount']?></span> руб.</div>
                    <?php if($arrPayment['two_prices'] == 'Y'): ?>
                    <form class="different-price-block hidden">
                        <a class="edit-prices" href="javascript:void(0)">Изменить</a>
                        <input type="submit" class="btn btn-small btn-green hidden save-changes" href="javascript:void(0)" value="Сохранить">
                        <table>
                            <tr>
                                <td class="custom">c</td>
                                <td class="date"><?= date_format(date_create($arrResult['dateStart']), "d.m")?></td>
                                <td class="custom">по</td>
                                <td class="date"><?= date_format(date_create($arrResult['second_price_start']), "d.m")?></td>
                                <td class="cost">
                                    <span class="view"><?=$arrResult['price']?> руб.</span>
                                    <input name="first_price" type="text" class="input hidden" value="<?=$arrResult['price']?> ">
                                </td>
                                <td class="duration"><?= getDaysCount($arrResult['second_price_start'], $arrResult['dateStart'])?> ночей</td>
                            </tr>
                            <tr>
                                <td class="custom">c</td>
                                <td class="date"><?= date_format(date_create($arrResult['second_price_start']), "d.m")?></td>
                                <td class="custom">по</td>
                                <td class="date"><?= date_format(date_create($arrResult['dateEnd']), "d.m")?></td>
                                <td class="cost">
                                    <span class="view"><?=$arrResult['second_price']?>  руб.</span>
                                    <input name="second_price" type="text" class="input hidden" value="<?=$arrResult['second_price']?>">
                                </td>
                                <td class="duration"><?= getDaysCount($arrResult['dateEnd'],$arrResult['second_price_start'])?> ночи</td>
                            </tr>

                        </table>
                    </form>
                    <?php else: ?>
                        <form class="price-form hidden">
                            <input type="text" id="total_price_val" value="<?= $arrPayment['amount']?>" class="input edit-price ">
                            <span class="btn btn-small btn-green confirm-price" id="confirm-total-price">ок</span>
                        </form>
                   <?php endif; ?>
                </div>
            <?php if($arrPayment['two_prices'] == 'N'): ?>
             <div class="half-len night-price-wrapper">
                <div class="price-header">
                    Цена за сутки:
                </div>
                    <div class="booking-total-amount">
                        <span class="price-value price-val" id="night_price_text"><?=$arrPayment['price']?></span> руб.
                    </div>
                    <form class="price-form hidden">
                        <input type="text" id="night_price" value="<?=$arrPayment['price']?>" class="input edit-price ">
                        <span  class="btn btn-small btn-green confirm-price" id="confirm-night-price">ок</span>
                    </form>
            </div>
            <?php endif;?>
            </div>
            <div class="check-desk">
                <div class="booking-block-header">
                    <h3>Оплата</h3>
                </div>
                <div class="row cashdesk-row">
                    <div class="half-len bold">Проживание:</div>
                    <div class="half-len"><?=$arrPayment['amount']?> руб.</div>
                </div>
                <div class="row cashdesk-row">
                    <div class="half-len bold">Доп. услуги:</div>
                    <div class="half-len"><?=$arrPayment['servicesAmount']?> руб.</div>
                </div>
                <div class="row cashdesk-row total-to-pay">
                    <div class="half-len bold">Итого:</div>
                    <div class="half-len"><?= $arrPayment['totalPrice']?> руб.</div>
                </div>
                <div class="row cashdesk-row">
                    <div class="half-len bold">Оплачено:</div>
                    <div class="half-len"> <?= $arrPayment['has_payed'] ?> руб.</div>
                </div>
                <div class="row cashdesk-row">
                    <div class="half-len bold">Возврат:</div>
                    <div class="half-len"> <?= separateThousands($arrPayment['returns']) ?> руб.</div>
                </div>
                <div class="row cashdesk-row">
                    <div class="half-len bold ">Задолженность:</div>
                    <div class="<?= $arrPayment['debt_class'] ?> half-len "><?= $arrPayment['amount_to_pay'] ?>  руб.</div>
                </div>
                <div class="button-wrapper">
                    <?php if($arrPayment['amount_to_pay'] > 0): ?>
                        <button data-action="add_payment" data-id="<?= $arrResult['id']?>" data-modal="modal" class="btn btn-big btn-green">Внести платёж</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <form method="post" action="/admin/booking_page/edit_comment/<?=$arrResult['id']?>" class="bottom-block form-vertical comment">
            <div class="row">
                <div class="label">
                    <label>Комментарий:</label>
                </div>
            </div>
            <textarea name="comment[comment]" rows="4" cols="4" class="input textarea"><?=$arrResult['comment']?></textarea>

            <div class="button-wrapper">
                <input id="save_comment" name="comment[submit]" type="submit" class="btn btn-small btn-green hidden"  value="Сохранить">
            </div>
        </form>
        <div class="bottom-block services-block">
            <div class="bottom-block-header">
                <div class="text bold">Услуги</div>
                <button id="add_service" data-action="add_service" data-id="<?=$arrResult['id']?>" data-modal="modal" class="btn btn-small btn-yellow">Добавить</button>
            </div>
            <div class="bottom-block-body">
                <table class="services-list">
                    <?php foreach ($services as $service):?>
                        <tr data-modal="modal" data-action="edit_service" data-id="<?=$service['id']?>" class="btn-modal service-item">
                            <span class="service-id"></span>
                            <td class="name"><?=$service['name']?></td>
                            <td class="quantity"><?=$service['quantity']?></td>
                            <td class="total"><?=$service['price']?> руб.</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <div class="bottom-block deposit-block">
            <?php foreach ($deposits as $deposit): ?>
                <div class="row">
                    <div class="half-len">
                        Залог за <?= $deposit['text']?>
                    </div>
                    <div class="half-len">
                        <a  href="/admin/booking_page/<?=$deposit['action']?>/<?=$arrResult['id']?>" class="btn btn-small <?= $deposit['btn']?>"><?= $deposit['btn_text']?></a>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php
include('footer.php');
