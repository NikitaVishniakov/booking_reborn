<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 05.08.17
 * Time: 22:55
 */

namespace controllers;


use core\base\Model;

class Settings extends \core\base\Controller
{

    public function indexAction(){
        $permission = array('main');
        accessControl($permission);

    }

    public function prolongationAction(){
        $permission = array('main');
        accessControl($permission);

        if(isset($_POST['prolongation'])){
            $this->layout = false;
            if(Model::update('settings', $_POST['prolongation'], 1)){
                header('location:' . $_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function ratesAction()
    {
        $permission = array('main');
        accessControl($permission);

        if (isset($_POST['rate'])) {
            unset($_POST['rate']['submit']);
            foreach ($_POST['rate'] as $id => $rate) {
                $rate['DATE_START'] = date("Y-m-d", strtotime($rate['DATE_START']));
                $rate['DATE_END'] = date("Y-m-d", strtotime($rate['DATE_END']));
                if (Model::update('rates', $rate, intval($id))) {
//                }
                }
            }

        }
    }
    public function addRateAction()
    {
        if (isset($_POST['rate'])) {
            unset($_POST['rate']['submit']);
            $rate = $_POST['rate'];
            $rate['DATE_START'] = date("Y-m-d", strtotime($rate['DATE_START']));
            $rate['DATE_END'] = date("Y-m-d", strtotime($rate['DATE_END']));
            foreach ($rate['RATE'] as $guests => $price){
                $temp = array('GUESTS' => $guests, 'RATE' => $price);
                $arr =  array_merge($rate, $temp);
                if (Model::save('rates', $arr)) {
                    $saved = true;
                }
                else{
                    $saved = false;
                }
            }

            if($saved){
                header("location:{$_SERVER['HTTP_REFERER']}");
            }

        }
    }

    public  function additionalBedCostAction(){
        $this->layout = false;
        if(isset($_POST['additional_bed'])){
            $bed = $_POST['additional_bed'];
            unset($bed['submit']);
            if(Model::update('settings', $bed, 1)){
                header("location:{$_SERVER['HTTP_REFERER']}");
            }
        }
    }


    public function siteAction(){
        $permission = array('main');
        accessControl($permission);


        if(isset($_POST['submit'])){
            $this->layout = false;

            foreach ($_POST['ROOM_SETTINGS'] as $key => $room){
                if(Model::update('landing', $room, $key)){
                    header('location:' . $_SERVER['HTTP_REFERER']);
                }
            }
        }

    }
}