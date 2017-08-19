<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 02.07.17
 * Time: 23:11
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Внесение нового расхода</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<form method="post" action="/admin/finance/add_cost" class="form form-vertical form-add-cost">
<div class="modal-content">
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Наименование:</label>
                </div>
                <div class="input-wrapper">
                    <input required class="input cost-name" name="cost[NAME]" type="text">
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Дата:</label>
                </div>
                <div class="input-wrapper">
                    <input required class="input datepicker-here" name="cost[DATE]" type="text" value="<?=date("d.m.Y")?>">
                </div>
            </div>
            </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Выберите категорию:</label>
                </div>
                <div class="input-wrapper">
                    <select required class="input select" id="cost-category" name="cost[CATEGORY]" type="text">
                        <?php
                        foreach ($categories as $category) echo $category;
                        ?>
                    </select>
                    <a href="#" data-modal="modal-small" data-action="add_cost_category" data-id="" class="btn-modal" >+ Добавить категорию</a>
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Выберите подкатегорию:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" id="cost-sub-category" name="cost[SUB_CATEGORY]" type="text">
                        <?php
                        foreach ($subcategories as $subcategory) echo $subcategory;
                        ?>
                    </select>
                    <a href="#" data-modal="modal-small"  data-action="add_cost_subcat" class="btn-modal">+ Добавить подкатегорию</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Введите сумму:</label>
                </div>
                <div class="input-wrapper">
                    <input required type="number" class="input" name="cost[AMOUNT]">
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Способ оплаты:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="cost[PAYMENT_TYPE]" type="text">
                        <option>Наличные</option>
                        <option>Безналичный расчет</option>
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
                    <input type="number" class="input" name="cost[QUANTITY]">
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Единица измерения:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="cost[UNIT]" type="text">
                        <option>Кг.</option>
                        <option>Шт.</option>
                    </select>
                </div>
            </div>
        </div>
</div>
<div class="modal-footer">
    <div id="cancel" class="btn btn-big btn-default">Отмена</div>
    <input type="submit" name="cost[submit]" class="btn btn-big btn-green" value="Сохранить"/>
</div>
</form>

