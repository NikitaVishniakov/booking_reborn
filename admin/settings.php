<?php
require("header.php");
?>
<div class="container-fluid users-container">
    <?php require("components/settings-menu.php"); ?>
    <div class="col-md-9 main-body">
        <div class="row">
<?php 
if(isset($_POST['submit_settings'])){
    update_multiple('settings', 'submit_settings');
}
$settings= $link->query("SELECT PROLONGATION_HOURS_MAX, PROLONGATION_HOURS_START, PROLONGATION_HOURS_STEP, PROLONGATION_PRICE_OPTION FROM settings")->fetch_array();
?>
                <form class="gray-border form col-md-8   col-md-offset-1" method="post" action="#">
                    <h2 id="prolongation">Продления</h2>
                   <input id="max-prolongation-hours" name="ID" class="form-control hidden" value="1">
                    <div class="row">
                        <label class="half-len text-right" for="PROLONGATION_HOURS_START">Платное продление начинается с:</label>
                        <select id="PROLONGATION_HOURS_START" name="PROLONGATION_HOURS_START" class="form-control"><?php prolongationMaxHours($settings['PROLONGATION_HOURS_START']); ?></select>
                    </div>
                    <div class="row">
                        <label class="half-len text-right" for="PROLONGATION_HOURS_MAX">Почасовое продление возможно до:</label>
                        <select id="PROLONGATION_HOURS_MAX" name="PROLONGATION_HOURS_MAX" class="form-control"><?php prolongationMaxHours($settings['PROLONGATION_HOURS_MAX']); ?></select>
                    </div>
                    <div class="row">
                        <label class="half-len text-right" for="PROLONGATION_HOURS_STEP">Шаг продления:</label>
                        <select id="PROLONGATION_HOURS_STEP" name="PROLONGATION_HOURS_STEP" class="form-control">
                            <?php prolongationStep($settings['PROLONGATION_HOURS_STEP']); ?>	
                        </select>
                    </div>
                    <div class="row">
                        <label class=" text-right" for="PROLONGATION_PRICE_OPTION">Стоимость часа:</label>
<?php prolongationCostType($settings['PROLONGATION_PRICE_OPTION']); ?>
                    </div>
                    <input type="submit" name="submit_settings" class="btn btn-success btn-days" value="Сохранить">
                </form>
        </div>
    </div>
    <script>
        $(document).ready(function(){
           $('#PROLONGATION_PRICE_OPTION').change(function(){
                var value = $('#PROLONGATION_PRICE_OPTION').val(); 
                if(value == 3){
                    $('.fixed-price-input-hours').prop("disabled", false);
                    $('.fixed-price-input-hours').removeClass('hidden');
                }
               else{
                    $('.fixed-price-input-hours').prop("disabled", true);
                    $('.fixed-price-input-hours').addClass('hidden');
                };
           });
        });
    </script>
<?php
require("footer.php");
?>
