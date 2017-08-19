<div class="main-container">
    <div class="page-header">
        <div class="left">
            Поиск
        </div>
    </div>
    <div class="incomes-container">
        <?php if($result): ?>
            <form name="form_search" method="get" action="/admin/search/search" class="form form-horizontal ">
                <div class="row">
                    <div class="label">
                        <input name="search" required class="input" type="text" placeholder="Введите имя гостя.." class="input">
                    </div>
                    <div class="input-wrapper">
                        <input type="submit" name="submit_search" class="btn btn-small btn-green" value="Искать" />
                    </div>
                </div>
            </form>
        <table class="table table-costs">
            <thead>
            <th>Имя гостя</th>
            <th>Бронировал</th>
            <th>Въезд</th>
            <th>Выезд</th>
            <th>Номер</th>
            </thead>

            <tbody>
            <?php foreach ($result as $item): ?>
                <tr class="<?php if($item['canceled']) echo 'canceled_booking';?>" onclick="window.location.href='/admin/booking_page/<?=$item['id']?>'; return false">
                    <td><?=$item['guestName']?></td>
                    <td><?=$item['booker']?></td>
                    <td><?=date_format(date_create($item['dateStart']), "d.m.Y")?></td>
                    <td><?=date_format(date_create($item['dateEnd']), "d.m.Y")?></td>
                    <td><?=$item['roomNum']?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
        <?php else: ?>
            <div class="no-results">
                <p>К сожалению, по вашему запросу ничего не найдено :( <br> Попробуйте другой запрос</p>
                <form name="form_search" method="get" action="/admin/search/search" class="form form-horizontal ">
                    <div class="row">
                        <div class="label">
                            <input name="search" required class="input" type="text" placeholder="Введите имя гостя.." class="input">
                        </div>
                        <div class="input-wrapper">
                            <input type="submit" name="submit_search" class="btn btn-small btn-green" value="Искать" />
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>