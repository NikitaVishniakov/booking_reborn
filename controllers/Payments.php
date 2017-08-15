<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 25.07.17
 * Time: 22:16
 */

namespace controllers;
use models\{Payment, Booking};


class Payments extends \core\base\Controller
{

    public function __construct($route, $layout = false){
        $this->route = $route;
        $this->view = $route['action'];
        $this->layout = $layout;
    }

    /**
     * Добавления платежа при заезде
     */
    public function checkInAction(){
        global $link;
        if(Payment::save('payments', $_POST)){
            $id = $_POST['bookingId'];
            $arrData = array(
                'checkIn' => 1,
                'isConfirmed' => 1
            );
            Booking::update('booking', $arrData, $id );
            header("location:{$_SERVER['HTTP_REFERER']}");
        }
        else{
            echo "Ошибка при добавлении платежа";
        }
    }

    /**
     * Добавление платежа из блока предавторизаций
     */
    public function prePaymentAction(){
        global $link;
        if(Payment::save('payments', $_POST)){
            $id = $_POST['bookingId'];
            $arrData = array(
                'isConfirmed' => 1
            );
            Booking::update('booking', $arrData, $id );
            header("location:{$_SERVER['HTTP_REFERER']}");
        }
        else{
            echo "Ошибка при добавлении платежа";
        }
    }

    /**
     * Добавление платежей
     *
     */
    public function addAction()
    {
        if(intval($_POST['amount']) <= 0){
            die();
        }

        if(Payment::save('payments', $_POST)) {
            header("location:{$_SERVER['HTTP_REFERER']}");
        }
        else{
            echo "Ошибка при добавлении платежа";
        }

    }


    public function editPaymentAction(){
        if(Payment::update('payments', $_POST, $this->route['id'])){
            header("location:{$_SERVER['HTTP_REFERER']}");
        }
    }

    public function deletePaymentAction(){
        $this->layout = false;
        $groups = array('main');

        accessControl($groups);

        if(Payment::delete('payments', $this->route['id'])){
            header('location:' . $_SERVER['HTTP_REFERER']);
        }
    }

}