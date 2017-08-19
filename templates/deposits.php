<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 07.07.17
 * Time: 20:31
 */
?>
<div class="main-container">
    <h1> Залоги</h1>
    <div class="deposits-container">
        <p>Сегодня, <?=$date; ?>, у вас <?=$depositsText?></p>
        <?php if($arrDeposits): ?>
        <table class="table table-deposits">
            <thead>
                <tr>
                    <th>Номер</th>
                    <th>Гость</th>
                    <th>Тип залога</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($arrDeposits as $item): ?>
                <tr>
                    <td>Номер № <?=$item['roomNum']?></td>
                    <td><a class="guest_name" href="/admin/booking_page/<?=$item['id']?>"> <?=$item['guestName']?></a></td>
                    <td><?=$item['depositType']?></td>
                    <td><?=$item['depositSum']?> руб.</td>
                </tr>
                <? endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    </div>
</div>
<?php
    include "footer.php";
?>