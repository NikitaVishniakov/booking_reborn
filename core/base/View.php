<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 15.07.17
 * Time: 14:11
 */

namespace core\base;


class View
{
    public $route = [];

    public $view = [];

    public $layout = [];

    public function __construct($route,$layout = '', $view = '')
    {
        $this->route = $route;
        $this->layout = $layout;
        $this->view = $view;
    }
    public function render($vars){
        if(is_array($vars)) extract($vars);

        $file_view = VIEWS . $this->route['controller'] . '/' . $this->view . '.php';
//        ob_start();
        if($this->layout){
            require_once HEADER;
        }
//        debug($file_view);
        if(is_file($file_view)){
            require_once $file_view;
        }

        if($this->layout){
            require_once FOOTER;
        }
//        $content = ob_get_clean();
//        echo $content;
    }
}