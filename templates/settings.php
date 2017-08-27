<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 27.08.17
 * Time: 17:35
 */
?>
<div class="main-container">
    <div class="page-header">Настройки</div>
    <form class="form-horizontal" action="/admin/settings/" method="post">
        <div class="settings-block">
            <div class="settings-header ">
                <h3>Настройки отеля</h3>
            </div>
            <div class=" row">
                <div class="label">
                    <label class="">Название отеля:</label>
                </div>
                <div class="input-wrapper">
                    <input class="input" name="main[HOTEL_NAME]" value="<?=$hotel['NAME']?>"/ >
                </div>
            </div>
        </div>
        <div class="button-wrapper">
            <input type="submit" name="prolongation[submit]" value="Сохранить изменения" class="btn btn-big btn-green">
            <a href="<?=$_SERVER['REQUEST_URI']?>" class="btn btn-big btn-default"> Отмена</a>
        </div>
    </form>
</div>
