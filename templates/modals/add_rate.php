<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 27.08.17
 * Time: 20:53
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Добавить тариф</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<form class="form form-horizontal" method="post" action="/admin/settings/add_rate">
    <div class="modal-content">
        <div class="row">
            <div class="label">
                <label class="">Дата начала:</label>
            </div>
            <div class="input-wrapper">
                <input required class="input datepicker-here" name="rate[DATE_START]" type="text">
            </div>
            <div class="clear"></div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Дата окончания:</label>
            </div>
            <div class="input-wrapper">
                <input required class="input datepicker-here" name="rate[DATE_END]" type="text">

            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Категория:</label>
            </div>
            <div class="input-wrapper">
                <select class="input select" name="rate[CATEGORY]">
                    <?php selectCategory($this->route['id']); ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="label">
                <h3 class="">Цены</h3>
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">1 гость:</label>
            </div>
            <div class="input-wrapper">
                <input required class="input" name="rate[RATE][1]" type="number">
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">2 гостя:</label>
            </div>
            <div class="input-wrapper">
                <input required class="input" name="rate[RATE][2]" type="number">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div id="cancel" class="btn btn-big btn-default">Отмена</div>
        <input type="submit" name="rate[submit]" class="btn btn-big btn-green" value="Сохранить" />
    </div>
</form>

