<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 27.08.17
 * Time: 17:40
 */
$additional_bed = \core\base\Model::getPropertyList('settings', 1, array('ADDITIONAL_BED_COST'))['ADDITIONAL_BED_COST'];

$categories = \core\base\Model::getElementList('categories');
$rates = \core\base\Model::getElementList('rates');
$arrRates = [];
if(!$categories){
    $categories = array();
}
if(!$rates){
    $rates = array();
}
foreach ($categories as $category){
    foreach ($rates as $rate){
        if($rate['CATEGORY'] == $category['ID']){
            $arrRates[$category['CATEGORY']][] = $rate;
        }
    }
}

require_once TEMPLATES . "rates.php";
