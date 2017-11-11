<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 10.07.17
 * Time: 21:31
 */

namespace controllers;


class Site extends \core\base\Controller
{
    public function indexAction(){
        $this->layout = false;
        include PUBLIC_PATH . 'index.php';
    }
    public function sendMailAction(){
        $this->layout = false;
        include PUBLIC_PATH . 'send_mail.php';
    }
}