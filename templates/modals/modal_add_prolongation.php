<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 08.07.17
 * Time: 14:54
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Почасовое продление</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<form method="post" action="/admin/booking_page/addProlongationHours/" class="form form-horizontal form-add-cat">
    <input type="hidden" name="prolongation[b_id]" value="<?=$booking_id?>">
    <input type="hidden" name="prolongation[name]" value="<?=$name?>">
    <input type="hidden" name="prolongation[whoAdd]" value="<?=$_SESSION['id']?>">
    <div class="modal-content">
        <div class="row">
            <div class="label">
                <label class="">Продление c:</label>
            </div>
            <div class="input-wrapper">
                <span id="hours_start"><?=$arrSettings['PROLONGATION_HOURS_START']?></span>
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Продление до:</label>
            </div>
            <div class="input-wrapper">
                <select class="input select" id="prolongation_hours" name="TIME">
                    <?php prolongationHourOptions($arrSettings) ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Стоитмость часа (руб.):</label>
            </div>
            <div class="input-wrapper">
                <input name="hour_price" class="input" id="prolongation_hour_cost" value="<?=$price_per_hour?>" />
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Количество часов:</label>
            </div>
            <div class="input-wrapper">
                <input type="text" class="input" name="prolongation[quantity]" readonly id="prolongation_hour_quantity" value="<?=$hours?>"/>
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Итоговая стоимость (руб.):</label>
            </div>
            <div class="input-wrapper">
                <input type="text" class="input" name="prolongation[price]" id="prolongation_hour_total" value="<?=$total_price?>" />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div id="cancel" class="btn btn-big btn-default">Отмена</div>
        <input name="prolongation[submit]" type="submit" value="Сохранить" class="btn btn-big btn-green" />
    </div>
</form>
