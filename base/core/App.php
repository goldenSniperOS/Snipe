<?php namespace Snipe\Core;

class App{
    private $controller = 'home';
    private $method = 'index';
    private $params = [];

    private static $routes = [];

    function __construct() {
        //Method
        $method = $_SERVER['REQUEST_METHOD'];

        //ParseURL
        $url = $this->parseURL();

        //Controller Analyse
        $controllerRoutes = array_values(array_filter(self::$routes,function($route){
            return $route['type'] == 'controller';
        }));

        if(count($controllerRoutes) != 0){
            if($ruta = self::foundRoute([$url[0]],$controllerRoutes)){
                if(count($url) >= 2){
                    $params = array_splice($url,2);
                    $this->method = strtolower($method).ucfirst($url[1]);
                    if($code = $this->callController($ruta['route'],explode('@',$ruta['function'].'@'.$this->method),$params) != 4){
                        switch ($code) {
                            case 1:
                                echo 'Sintaxis mal escrita';
                                break;
                            case 2:
                                echo 'No existe el controlador';
                                break;
                            case 3:
                                echo 'No existe la función en el controlador';
                                break;
                        }
                    }
                    die();
                }else{
                    $params = array_splice($url,2);
                    $this->method = strtolower($method).ucfirst($this->method);
                    if($code = $this->callController($ruta['route'],explode('@',$ruta['function'].'@'.$this->method),$params) != 4){
                        switch ($code) {
                            case 1:
                                echo 'Sintaxis mal escrita';
                                break;
                            case 2:
                                echo 'No existe el controlador';
                                break;
                            case 3:
                                echo 'No existe la función en el controlador';
                                break;
                        }
                    }
                    die();
                }
            }
        }

        //Before Get and Post Data Simple URL's
        $searchArray = array_values(array_filter(self::$routes,function($route){
            return $route['type'] == strtolower($_SERVER['REQUEST_METHOD']);
        }));



        if (isset($url)) {
            if(count($searchArray) != 0){
                if($ruta = self::foundRoute($url,$searchArray)){
                    $params = array_splice($url,count($ruta['route']));
                    if(is_callable($ruta['function'])){
                        call_user_func_array($ruta['function'],$params);
                    }else{
                       if($code = $this->callController($ruta['route'],explode('@',$ruta['function']),$params) != 4){
                            switch ($code) {
                                case 1:
                                    echo 'Sintaxis mal escrita';
                                    break;
                                case 2:
                                    echo 'No existe el controlador';
                                    break;
                                case 3:
                                    echo 'No existe la función en el controlador';
                                    break;
                            }
                        }
                        die();
                    }
                }else{
                    //echo 'Ruta no Encontrada';
                    Redirect::to(404);
                }
            }
        }else{
            //Data for Home
            $homeExists = array_values(array_filter(self::$routes,function($route){
                return $route['literal'] == '/';
            }));
            if(count($homeExists) != 0){
                if(is_callable($homeExists[0]['function'])){
                    call_user_func($homeExists[0]['function']);
                }else{
                    if($code = $this->callController($homeExists[0]['route'],explode('@',$homeExists[0]['function'])) != 4){
                        switch ($code) {
                            case 1:
                                echo 'Sintaxis mal escrita';
                                break;
                            case 2:
                                echo 'No existe el controlador';
                                break;
                            case 3:
                                echo 'No existe la función en el controlador';
                                break;
                        }
                    }
                    die();
                }
            }else{
                echo 'Ruta Principal No definida';
            }
        }
    }

    private function callController($ruta,$fuente,$params = []){
        if(count($fuente) == 2){
            if ($file = Tools::fileExists(Path::to('app').DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$fuente[0].'.php',false)) {
                $this->controller = $fuente[0];
                require_once $file;
                $this->controller = new $this->controller;
                if (method_exists($this->controller, $fuente[1])) {
                    $this->method = $fuente[1];
                } else {
                    return 3;
                }
                $this->params = $params;
                call_user_func_array([$this->controller, $this->method], $this->params);
                return 4;
            } else {
                return 2;
            }
        }else{
            return 1;
        }
    }

    public static function addRoute($route){
        static::$routes[] = $route;
    }

    private static function foundRoute($url,$searchArray){
        foreach ($searchArray as $route) {
            if(self::sameRoute($route,$url)){
                //Modo estricto de Rutas
                /*if(false){
                    if(count($url) == (count($route['params'])+count($route['route']))){
                        return $route;
                    }else{
                        return false;
                    }
                }*/
                return $route;
            }
        }
        return false;
    }

    private static function sameRoute($route,$url){
        foreach ($route['route'] as $key) {
            if(!in_array($key, $url)){
                return false;
            }
        }
        return true;
    }

    private function parseURL() {
        if (isset($_GET['url'])) {
            $url = explode('/', filter_var(rtrim(str_replace(" ", "%20", $_GET['url']), '/'), FILTER_SANITIZE_URL));
            unset($_GET['url']);
            return $url;
        }
    }
}
