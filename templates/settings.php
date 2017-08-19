<div class="main-container">
    <div class="page-header">Настройки</div>
    <div class="settings-block incomes-container">
        <div class="settings-header ">
            <h3>Настройки продления</h3>
        </div>
        <form class="form-horizontal" action="/admin/settings/prolongation" method="post">
            <div class=" row">
                <div class="label">
                    <label class="">Начало платного продления:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="prolongation[PROLONGATION_HOURS_START]">
                        <?php foreach ($startHours as $option): ?>
                            <?=$option?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class=" row">
                <div class="label">
                    <label class="">Почасовое продление возможно до:</label>
                </div>
                <div class="input-wrapper">
                    <select class="input select" name="prolongation[PROLONGATION_HOURS_MAX]">
                        <?php foreach ($endHours as $option): ?>
                            <?=$option?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <input type="submit" name="prolongation[submit]" value="Сохранить изменения" class="btn btn-big btn-green">
            </div>
        </form>
    </div>
    <div class="settings-block incomes-container">
        <div class="settings-header ">
            <h3>Настройки сайта</h3>
        </div>
        <form class="form-horizontal" action="/admin/settings/site" method="post">
            <?php foreach ($landing as $room): ?>
                <h3><?=$room['CATEGORY_NAME']?></h3>

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
            <?php endforeach; ?>
            <input type="submit" name="ROOM[submit]" value="Сохранить изменения" class="btn btn-big btn-green">
        </form>
    </div>
</div>