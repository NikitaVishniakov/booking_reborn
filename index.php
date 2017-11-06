<?php
    session_start();
    use core\Router;
    $query = trim(rtrim($_SERVER['REQUEST_URI'], '/'), '/');
    require_once($_SERVER['DOCUMENT_ROOT'].'/core/config.php');
    require_once(CORE . "connection.php");
    require_once(CORE . 'funcs.php');
    spl_autoload_register(function($class){
        $file = ROOT . '/' .str_replace('\\', '/', $class) . '.php';
        if(is_file($file)){
            require_once $file;
        }
    });
//    Router::addRoute('^admin/Users$',['controller' => 'Users', 'action' => 'Users']);
    Router::addRoute('^admin/booking_page/(?P<id>[\d+]+)$',['controller' => 'BookingPage', 'action' => 'index']);
    Router::addRoute('^admin/booking_page/(?P<action>[a-z_-]+)/(?P<id>[\d+]+)$',['controller' => 'BookingPage']);
    Router::addRoute('^admin/(?P<controller>[a-z_-]+)/(?P<action>[a-z_-]+)/(?P<id>[\d+]+)$');
//Дефолтные роуты - / и авторазбивка на контроллер и экшн
    Router::addRoute('^$',['controller' => 'Site', 'action' => 'index']);
    Router::addRoute('^admin$',['controller' => 'BookingTable', 'action' => 'index']);
    Router::addRoute('^admin/(?P<controller>[a-z_-]+)/?(?P<action>[a-z_-]+)?$');


    Router::dispatch($query);