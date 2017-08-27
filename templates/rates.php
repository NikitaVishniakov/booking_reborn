<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 27.08.17
 * Time: 17:40
 */
?>
<div class="main-container">
    <div class="page-header">Настройки > Настройки тарифов</div>
    <form class="form-horizontal" action="/admin/settings/additional_bed_cost" method="post">
        <div class="settings-block">
            <div class="row">
                <div class="label">
                    <label class="">Cтоимость доп. спального места:</label>
                </div>
                <div class="input-wrapper">
                    <input required class="input" name="additional_bed[ADDITIONAL_BED_COST]" type="number" value="<?=$additional_bed?>">
                </div>
                <div class="clear"></div>
            </div>
            <div class="button-wrapper">
                <input type="submit" name="additional_bed[submit]" class="btn-small btn btn-green" value="Сохранить">
            </div>
        </div>
    </form>
    <form class="form-horizontal" action="/admin/settings/rates" method="post">

        <?php foreach ($arrRates as $category => $rates): ?>
        <div class="settings-block">
            <div class="settings-header">
                <h3><?=$category?></h3>
            </div>
            <div class=" row">

                <div data-modal="modal" data-action="add_rate" data-id="<?=$rates[0]['CATEGORY']?>"class="add_rate btn btn-small btn-default">Добавить</div>

                <table class="table rates-table">
                    <thead>
                        <tr>
                            <th>Начало периода</th>
                            <th>Конец периода</th>
                            <th>Кол-во гостей</th>
                            <th>Стоимость (руб.)</th>
                        </tr>
                    </thead>
                    <tbody id="<?=$category?>">
                    <?php foreach($rates as $rate):?>
                        <tr>
                            <td><input type="text" class="input rates-input datepicker-here date" name="rate[<?=$rate['ID']?>][DATE_START]" value="<?= date("d.m.Y", strtotime($rate['DATE_START']))?>" ></td>
                            <td><input type="text" class="input rates-input datepicker-here date" name="rate[<?=$rate['ID']?>][DATE_END]" value="<?= date("d.m.Y", strtotime($rate['DATE_END']))?>" ></td>
                            <td><input disabled class="input rates-input guests" value="<?=$rate['GUESTS']?>" /></td>
                            <td><input type="number" class="input rates-input rate" name="rate[<?=$rate['ID']?>][RATE]" value="<?=$rate['RATE']?>"></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if(count($rates)):?>
        <div class="button-wrapper">
            <input type="submit" name="rate[submit]" value="Сохранить изменения" class="btn btn-big btn-green">
            <a href="<?=$_SERVER['REQUEST_URI']?>" class="btn btn-big btn-default"> Отмена</a>
        </div>
        <?php endif; ?>
    </form>
</div>
