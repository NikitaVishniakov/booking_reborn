<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 04.07.17
 * Time: 20:37
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Добавление услуги</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<form method="post" action="/admin/booking_page/add_service/" class="form form-vertical form-add-cost">
    <div class="modal-content">
            <input type="hidden" name="services[b_id]" value="<?=$id?>">
            <div class="row">
                <div class="label">
                    <label class="">Услуга:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="services[name]" type="text">
                        <?php foreach ($list as $item): ?>
                            <option value="<?=$item['id']?>"><?=$item['name']?> (<?=$item['price']?> руб.)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="label">
                    <label class="">Количество:</label>
                </div>
                <div class="input-wrapper">
                    <input type="number" value="1" class="input" name="services[quantity]">
                </div>
            </div>
    </div>
    <div class="modal-footer">
        <div id="cancel" class="btn btn-big btn-default">Отмена</div>
        <input type="submit" class="btn btn-big btn-green" value="Добавить">
    </div>
</form>


