<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 13.08.17
 * Time: 12:02
 */
$hotel =  new \models\Hotels;
debug($hotel);
$arrSettings = \core\base\Model::getPropertyList('settings',1);
$startHours = selectHours($arrSettings, $arrSettings['PROLONGATION_HOURS_START']);
$endHours = selectHours($arrSettings, $arrSettings['PROLONGATION_HOURS_MAX']);
//debug($endHours);

$landing = \core\base\Model::getElementList('landing');

require_once TEMPLATES . "/settings.php";
