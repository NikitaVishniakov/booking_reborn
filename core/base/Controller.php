<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 10.07.17
 * Time: 21:49
 */

namespace core\base;

abstract class Controller
{
    public $route = [];
    public $view;
    public $layout = true;
    public $vars = [];
    public $noView = false;

    public function __construct($route, $layout = true){
        $this->route = $route;
        $this->view = $route['action'];
        $this->layout = $layout;
    }

    /**
     * @return mixed
     */
    public function getView()
    {
//        if($this->noView)
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }


    /**
     * Передем данные из контроллера во вьюху
     * @return mixed
     */    public function setVariablesForView($vars){
        $this->vars = $vars;
    }
}