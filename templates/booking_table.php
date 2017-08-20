 <div class="main-container">
     <h4 class="today">Сегодня, <?=date("d.m.Y")?></h4>

        <div class="digest">
<!--            Блок с информацией на сегодня -->

            <div class="digest-block today-info">
                <?php
                foreach ($arrToday as $row): ?>
                    <div class="row <?= $row['NOT_ARRIVED']?>">
                        Номер <?= $row['roomNum'] ?>:
                        <span class="guest-status <?=$row['ACTION_CLASS']?>">
                            <span class="text"><?=$row['ACTION']?></span>
                            <span class="icon">
                                <i class="fa <?=$row['ICON']?>" aria-hidden="true"></i>
                            </span>
                        </span>
                        <a class="guest-name" href="/admin/booking_page/<?=$row['booking_id']?>"><?=$row['guestName']?></a>
                        <?php if ($row['DEBT']): ?>
                            <span class="guest-debt guest-action">
                                Долг: <?= money($row['DEBT'])?>
                            </span>
                        <? endif; ?>
                        <?php if ($row['BUTTON']['SHOW']): ?>
                            <span class="guest-action">
                                <a href="<?=$row['BUTTON']['HREF']?>" data-modal="<?=$row['DATA_MODAL']?>" data-action="<?= $row['BUTTON']['ACTION']?>" data-id="<?=$row['booking_id']?>" class="btn btn-small <?=$row['BUTTON']['CLASS']?>"><?=$row['BUTTON']['TEXT']?></a>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>


<!--            Блок с предоплатами и подтверждениями-->
            <?php if($arrNotConfirmed): ?>
            <div class="digest-block prepayments">
                <?php foreach ($arrNotConfirmed as $item): ?>
                <div class="row">
                    <span class="guest-status">
                        <span class="text"><?=$item['action_text']?></span>
                        <span class="icon">
                                <i class="fa <?=$item['icon']?>" aria-hidden="true"></i>
                            </span>
                    </span>
                    <a href="/admin/booking_page/<?=$item['booking_id']?>" class="booked_pole guest-name">
                        <?=$item['guestName']?> (заезд <?=$item['checkIn']?>)
                    </a>
                    <span class="guest-action">
                        <?php if ($item['action'] == 'pre-payment'){ ?>
                            <a id="prepayment" data-id="<?=$item['booking_id']?>" data-modal="<?=$item['modal']?>" data-action="<?=$item['action']?>" class="btn btn-small btn-default">Списать</a>
                        <?php } else { ?>
                            <a href="/admin/booking_page/confirm_booking/<?=$item['booking_id']?>" class="btn btn-small btn-green-no-bg">Подтвердить</a>
                        <?php } ?>
                    </span>
                </div>
                <?php endforeach;?>
            </div>
            <?php endif; ?>


        </div>
     <form class="form-vertical search-form" action="/admin/search/search" method="get">
         <div class="search-wrapper">
             <div class="label">
                 <label>Поиск бронирования:</label>
             </div>
             <div class="input-wrapper">
                 <input type="text" name="search" class="input input-search">
                 <span class="search-pad"><input type="submit" class="btn-seatch" value="" >
</span>
             </div>
         </div>
     </form>
        <div class="filter">
            <form novalidate="novalidate" class="form-vertical form-filter-date">
                <div class="date-wrapper">
                        <div class="label">
                            <label for="date">Дата начала:</label>
                        </div>
                        <div class="input-wrapper">
                            <i class="date-pad fa fa-calendar" aria-hidden="true"></i>
                            <input id="date" name="date" type="text" value="<?= $date ?>" class="date-input input datepicker-here">
                        </div>
                </div>
                <div class="period-wrapper">
                        <div class="label">
                            <label for="period">Период:</label>
                        </div>
                        <div class="input-wrapper">
                            <select id="period" name="period" class="input select">
                                <?php foreach($periods as $key => $value): ?>
                                <? $selected = ($period ==$key) ? 'selected' : '';?>
                                <option <?=$selected?> value="<?=$key?>"><?=$value?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                </div>
                <div class="btn-wrapper">
                    <input type="submit" name="submit_period" value="Показать" class="btn btn-small btn-green-no-bg">
                </div>
            </form>
            <div class="add-booking">
                <a data-action="add_booking" id="add_booking" data-modal="modal" class="btn btn-big btn-blue">Добавить бронирование</a>
            </div>
        </div>
    <div class="booking-table-container">

<!--        Формируем столбец с номерами-->

    <div class="rooms-block">
        <div class="spacer"></div>
        <?php foreach ($arrRooms as $room): ?>
            <div class="table-сell rooms">
                <div class='room'>
                   <span class="category-name"><?=$room['category']?></span> <?=$room['room']?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="spacer"></div>
    </div>


<!--        Формируем ряд с датами-->

        <div class="dates-block">
            <div class="table-cell date-cell"></div>
            <?php foreach ($arrDates as $th_date): ?>
                <div class='table-cell date-cell'>
                    <?=$th_date?>
                </div>
            <?php endforeach;?>
        </div>

<!--        Заполняем таблицу бронированиями-->

        <div class="bookings">
            <?php foreach ($arrBookings as $key => $row): ?>
                <div class="table-row" id="<?=$key?>">
                    <?php foreach ($row as $item): ?>
                        <?
                        if ($item['CLASS'] == 'free' || $item['CLASS'] == 'free move-out') {
                            $action_modal = "data-action='add_booking?dateStart={$item['ID']}'";
                        }
                        else{
                            $action_modal = '';
                        }
                        ?>
                        <a href='<?=$item['HREF']?>' id='<?=$key?>' <?=$action_modal?> class='booking-cell <?=$item['CLASS']?>' data-date='<?=$item['ID']?>' data-category="<?=$item['CATEGORY']?>" data-room="<?=$item['ROOM']?>">

                            <div class='icons-box'>
                                <i class="<?= $item['GENIOUS']?>" aria-hidden="true"></i>
                                <?=$item['BREAKFAST'] ?>
                                <i class='<?=$item['DEPOSIT'] ?>' aria-hidden="true"></i>
                            </div>
                            <div class="booking-info ">
                                <i class='<?=$item['STATUS']?>' aria-hidden="true"></i>
                                <span class='guest-name'><?=$item['GUEST']?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
<?php include('footer.php');