<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 08.07.17
 * Time: 14:54
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Добавить категорию</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<form method="post" action="/admin/finance/addCostCategory" class="form form-vertical form-add-cat">
<div class="modal-content">
        <div class="row">
            <div class="label">
                <label class="">Введите название категории</label>
            </div>
            <div class="input-wrapper">
                <input required name="category[NAME]" class="input" type="text">
            </div>
        </div>
</div>
<div class="modal-footer">
    <div id="cancel" class="btn btn-big btn-default">Отмена</div>
    <input name="category[submit]" type="submit" value="Сохранить" class="btn btn-big btn-green" />
</div>
</form>
