<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 04.07.17
 * Time: 20:42
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Просмотр услуги</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
    <div data-action="booking_page/delete_service" data-id="<?=$item['id']?>" class="btn need-confirm btn-small btn-red">Удалить</div>
</div>
<form action="/admin/booking_page/edit_service/<?=$this->route['id']?>" class="form form-horizontal form-add-cost">
    <input type="hidden" value="<?=$item['id']?>" name="service[id]">
    <div class="modal-content">
        <div class="row">
            <div class="label">
                <label class="">Услуга:</label>
            </div>
            <div class="input-wrapper">
                <select class="input select" name="service[name]" type="text">
                    <?php debug($listServices); foreach ($listServices as $service):
                        $selected = '';
                        if($item['name'] == $service['name']){
                            $selected = 'selected';
                        }
                        ?>
                        <option <?=$selected?> value="<?=$service['id']?>"><?=$service['name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Количество:</label>
            </div>
            <div class="input-wrapper">
                <input  value="<?=$item['quantity']?>" type="number" class="input" name="service[quantity]">
            </div>
        </div>
        <?php if(isset($item['whoAdd'])):?>
        <div class="row">
            <div class="label">
                <label class="">Кем добавлена услуга:</label>
            </div>
            <div class="input-wrapper">
                <div class="text"><?=$item['whoAdd']?></div>
            </div>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="label">
                <label class="">Дата добавления:</label>
            </div>
            <div class="input-wrapper">
                <div class="text"> <?=$date?></div>
            </div>
        </div>
</div>
<div class="modal-footer">
    <div id="cancel" class="btn btn-big btn-default">Отмена</div>
    <input type="submit" value="Сохранить" class="btn btn-big btn-green"/>
</div>
</form>
