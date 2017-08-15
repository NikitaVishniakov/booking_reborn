<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 14.06.17
 * Time: 21:17
 */
namespace core;
class Router {
    protected static $routes = [];
    protected static $route = [];

    public static function addRoute($regexp, $route = []){
        self::$routes[$regexp] = $route;
    }
    public static function getRoutes(){
        return self::$routes;
    }
    public static function getRoute(){
        return self::$route;
    }

    /**
     * @param $url
     * @return bool
     */
    public static function matchRoute($url){
        foreach (self::$routes as $pattern => $route){
            if(preg_match("#$pattern#i", $url, $matches)) {
                foreach ($matches as $key => $value){
                    if(is_string($key)){
                        $route[$key] = $value;
                    }
                }
                if(!isset($route['action'])){
                    $route['action'] = 'index';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * @param $name
     * @return mixed
     */
    protected static function upperCamelCase($name){
        $name = str_replace('_', ' ',str_replace('-', ' ', $name));
        $name = str_replace(' ', '', ucwords($name));
        return $name;
    }

    /**
     * @param $action
     * @return mixed|string
     */
    protected static function lowerCamelCase($action){
        $action = str_replace('_', ' ',str_replace('-', ' ', $action));
        $action = str_replace(' ', '', lcfirst(ucwords($action))).'Action';
        return $action;
    }

    /**
     * @param $url
     */
    public static function dispatch($url){
        $url = self::removeQueryString($url);
        if(self::matchRoute($url)){
            $controller = 'controllers\\' . self::$route['controller'];
            if(class_exists($controller)){
                $cObj = new $controller(self::$route);
                $action =  self::lowerCamelCase(self::$route['action']);
                if(method_exists($cObj, $action)){
                    $cObj -> $action();
                    $cObj -> getView();
                }
                else{
                    echo "Метод <strong>$controller::$action</strong> не найден";
                }
            }
            else{
                require_once HEADER;
                echo "Контроллер $controller не найден";
            }
        }
        else{
            http_response_code(404);
            require_once('404.php');
        }
    }
    public static function removeQueryString($url){
        if($url){
            $params = str_replace('?', '&', $url);
            $params = explode('&', $params, 2);
            if(false === strpos($params[0], '=')){
                return rtrim($params[0], '/');
            }
            else{
                return '';
            }
        }
    }
}
