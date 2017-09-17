<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 06.08.17
 * Time: 1:19
 */
$item = \models\Costs::getPropertyList('costs', $this->route['id']);
$arrCategory =  models\Costs::getElementList('costs_categories');
foreach ($arrCategory as $catItem){
    if($catItem['NAME'] == $item['CATEGORY']) $category_id = $catItem['ID'];
}
$units_options = selectGetUnity($item['UNIT']);

$categories = selectCostCategories($category_id);

$subcategories = selectCostSubCategories($category_id, $item['SUB_CATEGORY']);

require_once TEMPLATES . "/modals/modal_edit_cost.php";
