<div class="main-container">
    <div class="page-header">Настройки > Настройки сайта</div>
                <form class="form-horizontal" action="/admin/settings/site" method="post">
                    <?php foreach ($landing as $room): ?>
                    <div class="settings-block">
                        <div class="settings-header ">
                            <h3><?=$room['CATEGORY_NAME']?></h3>
                        </div>

                        <div class="row">
                            <div class="label">
                                <label class="">Название категории:</label>
                            </div>
                            <div class="input-wrapper">
                                <input type="text" class="input" name="ROOM_SETTINGS[<?=$room['ID']?>][CATEGORY_NAME]" value="<?=$room['CATEGORY_NAME']?>"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="label">
                                <label class="">Цена на сайте:</label>
                            </div>
                            <div class="input-wrapper">
                                <input type="text" class="input" name="ROOM_SETTINGS[<?=$room['ID']?>][ROOM_PRICE]" value="<?=$room['ROOM_PRICE']?>"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="label">
                                <label class="">Описание на сайте:</label>
                            </div>
                            <div class="input-wrapper">
                                <textarea class="input textarea-description" name="ROOM_SETTINGS[<?=$room['ID']?>][ROOM_DESCRIPTION]"><?=$room['ROOM_DESCRIPTION']?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="button-wrapper">
                        <input type="submit" name="ROOM[submit]" value="Сохранить изменения" class="btn btn-big btn-green">
                        <a href="<?=$_SERVER['REQUEST_URI']?>" class="btn btn-big btn-default"> Отмена</a>
                    </div>
                </form>

</div>