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
            Список доходов и расходов за
            <select name="" id="month-select" data-action="finance/incomes" class="month-select">
                <?php selectMonth($month) ?>
            </select>
            <label for="month-select" class="month-select-caret"><i class="fa fa-caret-down" aria-hidden="true"></i>
            </label>
        </div>
    </div>
    <div class="incomes-container">
        <?php foreach ($arrBalance as $cat_name => $category): ?>
        <div class="income-item">
            <div class="category-header has-children">
                <div class="category-name"><?=$cat_name?></div>
                <div class="category-total"><?=$category['total']?></div>
            </div>
            <div class="category-list">
                <table class="table">
                    <?php foreach ($category as $sub_cat_name => $subcat): ?>
                        <?php if($sub_cat_name != 'total'):?>
                                <tr>
                                    <td><?=$sub_cat_name?></td>
                                    <td><?=$subcat?></td>
                                </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="income-item revenue">
            <div class="category-header">
                    <div class="category-name">Прибыль</div>
                    <div class="category-total"><?=$cleanRevenue?></div>
            </div>
        </div>
    </div>
</div>
<?php
    include "footer.php";
?>

