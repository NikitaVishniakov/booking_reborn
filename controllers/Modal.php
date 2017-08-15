<?php
namespace controllers;

/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 07.07.17
 * Time: 20:22
 */

class Modal extends \core\base\Controller
{

    public function __construct($route, $layout = false)
    {
        $this->route = $route;
        $this->view = $route['action'];
        $this->layout = $layout;
    }


    public function checkInAction()
    {

    }

    public function addBookingAction()
    {

    }

    public function prePaymentAction()
    {

    }

    public function addPaymentAction()
    {

    }

    public function addServiceAction()
    {

    }

    public function editServiceAction()
    {

    }

    public function editPaymentAction()
    {

    }

    public function addCashdeskPaymentAction()
    {

    }

    public function addCashdeskCostAction()
    {

    }

    public function editCashdeskPaymentAction()
    {

    }

    public function addCostAction(){

    }

    public function editCostAction(){

    }

    public function addCostCategoryAction(){

    }

    public function addCostSubcatAction(){

    }
    public function addHourProlongationAction(){

    }

    public function addReturnAction(){

    }

    public function addUserAction(){

    }

    public function editUserAction(){

    }
}