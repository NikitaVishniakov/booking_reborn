<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 08.07.17
 * Time: 15:25
 */

?>
<div class="main-container">
    <div class="page-header">
        <div class="left">
            Отчет по оказанным услугам за
            <select name="" id="month-select" data-action="finance/services" class="month-select">
                <?php selectMonth($month) ?>
            </select>
            <label for="month-select" class="month-select-caret"><i class="fa fa-caret-down" aria-hidden="true"></i>
            </label>
        </div>
    </div>
    <div class="incomes-container">
        <?php foreach ($arrServices as $item): ?>
        <div class="income-item">
            <div class="has-children category-header">
                <div class="category-name"><?=$item['name']?> (<?=$item['total_quantity']?>)</div>
                <div class="category-total"><?=separateThousands($item['total_amount'])?> руб.</div>
            </div>
            <?php if(isset($item['LIST'])): ?>
            <div class="category-list">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Кол-во</th>
                            <th>Стоимость</th>
                            <th>Гость</th>
                        </tr>
                    </thead>
                    <?php foreach ($item['LIST'] as $services_item): ?>
                                <tr>
                                    <td><?=$services_item['name']?></td>
                                    <td><?=$services_item['quantity']?></td>
                                    <td><?=separateThousands($services_item['price'])?> руб.</td>
                                    <td><a href="/admin/booking_page/<?=$services_item['b_id']?>"><?=$services_item['guestName']?></a></td>
                                </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <? endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
    include "footer.php";
?>

