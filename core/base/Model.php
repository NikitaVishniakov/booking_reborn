<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 26.07.17
 * Time: 14:53
 */

namespace core\base;


class Model
{
    /**
     * @param $table_name - Название таблицы
     * @param $arrProperties - массив с необходимыми значениями
     * @param $id - айди необходимой записи
     * @return array
     */
    public static function getPropertyList($table_name, $id, $arrProperties = '*'){
        global $link;

        if(is_array($arrProperties)){
            $arrProperties = implode(', ', $arrProperties);
        }

        $sql = "SELECT $arrProperties FROM $table_name WHERE id = $id";
        $result = $link->query($sql);
        if($result) {
            if (mysqli_num_rows($result) == 0){
                return false;
            }
            return $result->fetch_assoc();
        }
        else{
            return false;
        }
    }

    /**
     * @param $table_name
     * @param array $arrProperties
     * @param int $filter
     * @return array|bool
     */
    public static function getElementList($table_name, $arrProperties = array(), $filter = 1){
        global $link;

        if(!empty($arrProperties)){
            $arrProperties = implode(', ', $arrProperties);
        }
        else{
            $arrProperties = '*';
        }

        $sql = "SELECT $arrProperties FROM $table_name WHERE $filter";
        $result = $link->query($sql);

        if($result) {
            if (!mysqli_num_rows($result)){
                return false;
            }
            while($row = $result->fetch_assoc()){
                $arr[] = $row;
            }
            return $arr;
        }
        else{
            return false;
        }
    }

    public static function save($table_name, $post_data){
        global $link;

        if(isset($post_data['submit'])){
            unset($post_data['submit']);
        }

        $colomns = implode(', ', array_keys($post_data));
        $values = "'" . implode("', '", $post_data) . "'";

        $sql = "INSERT INTO $table_name ($colomns) VALUES ($values)";
        $query = $link->query($sql);

        if ($query) {
            return true;
        } else {
            echo "ошибка при добавлении записи. Пожалуйста, попробуйте еще раз. В случае повторения ошибки, скиньте код ошибки в службу поддержки. <br> Код ошибки: {$link->error}<br>";
            echo $sql;
            return false;
        }
    }

    public static function update($table_name, $post_data, $id = ''){
        global $link;

        if(!$id){
            $id = $post_data['id'];
        }

        if(isset($post_data['submit'])){
            unset($post_data['submit']);
        }

        foreach ($post_data as $key => $value){
            $arr[] = "$key = '$value'";
        }
        $values = implode(', ', $arr);

        $sql = "UPDATE $table_name SET $values WHERE id = $id";
        $query = $link->query($sql);

        if ($query) {
            return true;
        } else {
            echo "ошибка при обновлении данных записи. Пожалуйста, попробуйте еще раз. В случае повторения ошибки, скиньте код ошибки в службу поддержки. <br> Код ошибки: {$link->error}<br>";
            echo $sql;
            return false;
        }
    }

    public static function delete($table_name, $id){
        global $link;

        $sql = "DELETE FROM $table_name WHERE id = $id";
        $query = $link->query($sql);

        if ($query) {
            return true;
        } else {
            echo "ошибка при удалении данных записи. Пожалуйста, попробуйте еще раз. В случае повторения ошибки, скиньте код ошибки в службу поддержки. <br> Код ошибки: {$link->error}<br>";
            echo $sql;
            return false;
        }

    }
    /**
     * @param $table_name
     * @param array $arrProperties
     * @param array $arrFilter
     * @param int $intLimit
     * @return array
     */
//    public static function getElementList($strTableName, $arrProperties = array(), $arrFilter = array(), $intLimit = 20)
//    {
//        global $link;
//
//        if(!empty($arrProperties)){
//            $arrProperties = implode(', ', $arrProperties);
//        }
//        else{
//            $arrProperties = '*';
//        }
//        //Если были переданы значения при вызове метода
//        if(!empty($arrFilter)){
//            //Пройдемся по массиву с переданными значениями, где ключ - поле таблицы
//            foreach ($arrFilter as $key => $value){
//                //Из значений с простой логикой формируем массив $strFilter и затем объединяем его в строку при помощи AND
//                if(!is_array($value)){
//                    $strFilter[]= "$key = '$value'";
//                }
//                //Если сложная логика, то обрабатываем ее
//                else{
//                    strtoupper($key);
//                    switch ($key){
//                        case 'CUSTOM':
//
//                    }
//
//                }
//            }
//            $strFilter = implode(' AND ', $strFilter);
//        }
//        else{
//            $strFilter = 1;
//
//        }
//        $sql = "SELECT $arrProperties FROM $strTableName WHERE $strFilter LIMIT $intLimit";
//        debug($sql);
//        $result = $link->query($sql);
//        if($result){
//            if (mysqli_num_rows($result) == 0){
//                return false;
//            }
//
//            while($row = $result->fetch_assoc()){
//                $arrResult[] = $row;
//            }
//
//            return $arrResult;
//        }
//        else{
//            return false;
//        }
//    }
}