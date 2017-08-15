<?php
/**
 * Created by PhpStorm.
 * User: vishniakov
 * Date: 12.08.17
 * Time: 23:47
 */

namespace models;


class Site extends \core\base\Model
{
    protected static $table_name = 'landing';

    public static function getRoomsList($category = ''){
        $filter = 1;
        if($category){
            $filter = "CATEGORY_ID = $category";
        }
       return self::getElementList(self::$table_name, array(), $filter);
    }

    public static function getRoomInfo($category){
        return self::getPropertyList(self::$table_name, $category);
    }
}