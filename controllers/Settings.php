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

    }

    public function prolongationAction(){
        if(isset($_POST['prolongation'])){
            if(Model::update('settings', $_POST['prolongation'], 1)){
                header('location:' . $_SERVER['HTTP_REFERER']);
            }
        }
    }


    public function siteAction(){
        $this->layout = false;

        foreach ($_POST['ROOM_SETTINGS'] as $key => $room){
            if(Model::update('landing', $room, $key)){
                header('location:' . $_SERVER['HTTP_REFERER']);
            }
        }
    }
}