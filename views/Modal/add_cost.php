<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 06.08.17
 * Time: 1:18
 */

$categories = selectCostCategories();
$subcategories = selectCostSubCategories(1);

require_once TEMPLATES . "/modals/modal_add_cost.php";
