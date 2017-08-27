<div class="main-container">
    <div class="page-header">Настройки > Настройки продления</div>
    <form class="form-horizontal" action="/admin/settings/prolongation" method="post">
        <div class="settings-block">
                <div class="settings-header ">
                    <h3>Настройки продления</h3>
                </div>
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
            </div>
        <div class="button-wrapper">
            <input type="submit" name="prolongation[submit]" value="Сохранить изменения" class="btn btn-big btn-green">
            <a href="<?=$_SERVER['REQUEST_URI']?>" class="btn btn-big btn-default"> Отмена</a>
        </div>
    </form>
</div>