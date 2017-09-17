<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 08.07.17
 * Time: 15:00
 */
?>
<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 02.07.17
 * Time: 23:11
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Редактирование расхода</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
    <div class="header-actions">
        <div data-action="finance/delete_cost" data-id="<?=$item['ID']?>" class="btn need-confirm btn-small btn-red">Удалить</div>
    </div>
</div>
<form  method="post" action="/admin/finance/update_cost" class="form form-vertical form-add-cost">
<div class="modal-content">
        <input type="hidden" name="cost[id]" value="<?=$item['ID']?>">
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Наименование:</label>
                </div>
                <div class="input-wrapper">
                    <input class="input" name="cost[NAME]" value="<?=$item['NAME']?>" type="text">
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Дата:</label>
                </div>
                <div class="input-wrapper">
                    <input required class="input datepicker-here" name="cost[DATE]" type="text" value="<?=date("d.m.Y", strtotime($item['DATE']))?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Выберите категорию:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="cost[CATEGORY]" type="text">
                        <?php
                        foreach ($categories as $category) echo $category;
                        ?>                    </select>
                    <a href="#" id="add_cat">+ Добавить категорию</a>
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Выберите подкатегорию:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="cost[SUB_CATEGORY]" type="text">
                        <?php
                        foreach ($subcategories as $subcategory) echo $subcategory;
                        ?>                    </select>
                    <a href="#" id="add_subcat">+ Добавить подкатегорию</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Введите сумму:</label>
                </div>
                <div class="input-wrapper">
                    <input type="number" value="<?=$item['AMOUNT']?>" class="input" name="cost[AMOUNT]">
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Способ оплаты:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select"  name="cost[PAYMENT_TYPE]" type="text">
                        <?php selectPaymentType($item['PAYMENT_TYPE'])?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Введите количество:</label>
                </div>
                <div class="input-wrapper">
                    <input type="number" VALUE="<?=$item['QUANTITY']?>" class="input" name="cost[QUANTITY]">
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Единица измерения:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="cost[UNIT]" type="text">
                        <?php foreach ($units_options as $unit) echo $unit?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Кем добавлено:</label>
                </div>
                <div class="input-wrapper">
                    <p>Марина</p>
                </div>
            </div>
        </div>
</div>
<div class="modal-footer">
    <div id="cancel" class="btn btn-big btn-default">Отмена</div>
    <input type="submit" name="cost[submit]" class="btn btn-big btn-green" value="Сохранить"/>
</div>
</form>

