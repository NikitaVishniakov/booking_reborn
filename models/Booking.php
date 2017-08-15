<?php
namespace models;
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 27.07.17
 * Time: 20:36
 */


class Booking extends \core\base\Model
{
    protected static $table_name = 'booking';
    protected static $payments = 'payments';
    protected static $services = 'services';

    public static function getDebt($id)
    {
        $toPay = self::getPropertyList(self::$table_name, $id, 'amount')['amount'] + self::getServicesAmount($id) - self::getPaymentsTotal($id);
        return $toPay;
    }

    public static function getPaymentsTotal($id)
    {
        global $link;
        $table = self::$payments;
        $payed = $link->query("SELECT SUM(amount) as total FROM $table WHERE bookingId ={$id} AND name not LIKE '%залог%' AND status = '+'")->fetch_array()['total'];
        $returned = $link->query("SELECT SUM(amount) as total FROM $table WHERE bookingId ={$id} AND status = '-'")->fetch_array()['total'];
        $total = $payed - $returned;
        return $total;
    }

    public static function getServicesAmount($id)
    {
        global $link;
        $table = self::$services;
        $servicesAmount = $link->query("SELECT SUM(price) as total FROM $table WHERE b_id = {$id}")->fetch_array()['total'];

        if (!$servicesAmount) {
            $servicesAmount = 0;
        }

        return $servicesAmount;
    }
    public static function safetyUpdate($post_data, $id = ''){
        $dates = array(&$post_data['dateStart'], &$post_data['dateEnd'], &$post_data['second_price_start']);
        foreach ($dates as &$date){
            if(strlen($date) > 0){
                $date = new \DateTime($date);
                $date = $date->format("Y-m-d");
            }
        }
        if(self::update(self::$table_name, $post_data, $id)){
            return true;
        }
        else{
            throw new \Exception('Ошибка добавления в базу');
        }
    }

    public static function getGuestName($id){
        $guestName = self::getPropertyList('booking', $id, array('guestName', 'booker'));
        $name = strlen($guestName['guestName']) > 0 ? $guestName['guestName'] : $guestName['booker'];
        return $name;
    }


}
