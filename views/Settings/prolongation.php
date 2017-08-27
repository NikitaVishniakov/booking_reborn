<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 13.08.17
 * Time: 12:02
 */
$hotel =  new \models\Hotels;
$arrSettings = \core\base\Model::getPropertyList('settings',1);
$startHours = selectHours($arrSettings, $arrSettings['PROLONGATION_HOURS_START'], '12:00');
$endHours = selectHours($arrSettings, $arrSettings['PROLONGATION_HOURS_MAX']);
//debug($endHours);

require_once TEMPLATES . "/prolongation-settings.php";
