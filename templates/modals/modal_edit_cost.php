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
    <div class="modal-header-text">Внесение нового расхода</div>
    <span class="modal-close"><i class="fa fa-times" aria-hidden="true"></i></span>
    <div class="header-actions">
        <div id="delete_service" class="btn btn-small btn-red">Удалить</div>
    </div>
</div>
<div class="modal-content">
    <form class="form form-vertical form-add-cost">
        <div class="row">
            <div class="label">
                <label class="">Наименование:</label>
            </div>
            <div class="input-wrapper">
                <input class="input cost-name" name="name" type="text">
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Выберите категорию:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="name" type="text">
                        <option>Категория 1</option>
                    </select>
                    <a href="#" id="add_cat">+ Добавить категорию</a>
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Выберите подкатегорию:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="name" type="text">
                        <option>Подкатегория 1</option>
                    </select>
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
                    <input type="number" class="input" name="">
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Способ оплаты:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="name" type="text">
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
                    <input type="number" class="input" name="">
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Единица измерения:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="name" type="text">
                        <option>Кг.</option>
                        <option>Шт.</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="half-len">
                <div class="label">
                    <label class="">Дата добавления:</label>
                </div>
                <div class="input-wrapper">
                    <p>12.12.2017</p>
                </div>
            </div>
            <div class="half-len">
                <div class="label">
                    <label class="">Кем добавлено:</label>
                </div>
                <div class="input-wrapper">
                    <p>Марина</p>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <div id="cancel" class="btn btn-big btn-default">Отмена</div>
    <div class="btn btn-big btn-green">Сохранить</div>
</div>

