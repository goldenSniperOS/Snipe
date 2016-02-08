<?php

class App {

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    function __construct() {
        $url = $this->parseURL();
        if (isset($url[0])) {
            if ($file = Tools::fileExists(Path::to('app').DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$url[0].'.php',false)) {
                $this->controller = $url[0];
                unset($url[0]);
                require_once $file;
                $this->controller = new $this->controller;
                if (isset($url[1])) {
                    if (method_exists($this->controller, $url[1])) {
                        $this->method = $url[1];
                        unset($url[1]);
                    } else {
                        echo 'El Metodo no Existe';
                        Redirect::to(404);
                        die();
                    }
                }
                $this->params = $url ? array_values($url) : [];
                call_user_func_array([$this->controller, $this->method], $this->params);
            } else {
                echo 'El Archivo No Existe';
                Redirect::to(404);
            }
        } else {
            require_once Path::to('app').DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$this->controller . '.php';
            $this->controller = new $this->controller;
            $this->params = [];
            call_user_func_array([$this->controller, $this->method], $this->params);
        }
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
