<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 13.08.17
 * Time: 12:02
 */
$hotel =  \models\Hotels::getPropertyList('HOTELS', $_SESSION['HOTEL']['ID']);
$arrSettings = \core\base\Model::getPropertyList('settings',1);
$startHours = selectHours($arrSettings, $arrSettings['PROLONGATION_HOURS_START']);
$endHours = selectHours($arrSettings, $arrSettings['PROLONGATION_HOURS_MAX']);
//debug($endHours);

require_once TEMPLATES . "/settings.php";
