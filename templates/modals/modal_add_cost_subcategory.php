<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 08.07.17
 * Time: 14:56
 */
?>
<div class="modal-header">
    <div class="modal-header-text">Добавить подкатегорию</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
</div>
<form method="post" action="/admin/finance/add_cost_subcategory" class="form form-vertical form-add-cat">
<div class="modal-content">
        <div class="row">
            <div class="label">
                <label class="">К какой категории доабвить подкатегорию?</label>
            </div>
            <div class="input-wrapper">
                <select name="subcategory[ID_CATEGORY]" required class="input select">
                    <?php
                        foreach ($categories as $category) echo $category;
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="label">
                <label class="">Введите название подкатегории</label>
            </div>
            <div class="input-wrapper">
                <input name="subcategory[NAME]" required class="input" type="text" class="input">
            </div>
        </div>
</div>
<div class="modal-footer">
    <div id="cancel" class="btn btn-big btn-default">Отмена</div>
    <input type="submit" name="subcategory[submit]" value="Сохранить" class="btn btn-big btn-green"/>
</div>
</form>
