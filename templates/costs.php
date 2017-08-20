<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 02.07.17
 * Time: 14:52
 */
?>

<div class="main-container">
    <div class="page-header">
        <div class="left">
            Список расходов за

                <select name="" id="month-select" data-action="finance/costs" class="month-select">
                    <?php selectMonth($month) ?>
                </select>
          <label for="month-select" class="month-select-caret"><i class="fa fa-caret-down" aria-hidden="true"></i>
            </label>
        </div>
        <div class="right">
            <span data-action="add_cost" data-modal="modal"  class="btn btn-small btn-default">Добавить элемент</span  >
        </div>
    </div>
    <div class="costs-container">
        <div class="costs-header"><span class="total-label"> Итого расходы: </span> <span class="total-value"><?=$totalCostsAmount?></span></div>
        <?php foreach ($costs as $cat_name => $category): ?>
            <div class="category">
                <div class="category-main">
                    <span class="category-name"><?=$cat_name?></span>
                    <span class="totals float-left"><?=separateThousands($totals[$cat_name])?> руб.</span>
                </div>
            </div>
            <div class="category-elements">
            <?php foreach ($category as $subcat_name => $subcat): ?>
            <div class="category">
                <div class="subcategory">
                    <span class="subcategory-name"><?=$subcat_name?></span>
                    <span class="totals float-left"><?=separateThousands($totals[$subcat_name])?> руб.</span>
                </div>
            </div>
            <div class="category-elements" style="display: none">
                <table class="table table-costs">
                    <thead>
                        <tr>
                            <th class="id">ID</th>
                            <th class="name">Наименование</th>
                            <th class="date">Дата</th>
                            <th class="amount">Сумма</th>
                            <th class="quantity">Количество</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($subcat as $item_name => $item): ?>
                        <tr class="cost-item btn-modal" data-modal="modal" data-action="edit_cost" data-id="<?=$item['ID']?>">
                            <td class="id"><?=$item['ID']?></td>
                            <td class="name"><?=$item['NAME']?></td>
                            <td class="date"><?=date_format(date_create($item['DATE']), "d.m.Y")?></td>
                            <td class="amount"><?=separateThousands($item['AMOUNT'])?> руб.</td>
                            <td class="quantity"><?=$item['QUANTITY']?> <?=$item['UNIT']?></td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endforeach;?>
            </div>
        <?php endforeach;?>
        </div>
</div>
<?php
include "footer.php";
