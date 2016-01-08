<?php
class View {
    public static function render($view, $data = [], $layout = null) {
        extract($data, EXTR_PREFIX_SAME, "wddx");
        $content = Config::path('app') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
        if($layout){
        	require_once Config::path('app') . DIRECTORY_SEPARATOR . 'themes/layouts' . DIRECTORY_SEPARATOR . $layout . '.php';
        }else{
        	require_once $content;
        }
    }

    public static function add($route,$data = []){
        extract($data, EXTR_PREFIX_SAME, "wddx");
        $rutas = explode('/', $route);
        $rutaCorrecta = implode(DIRECTORY_SEPARATOR,$rutas);
    	require_once Config::path('app') .DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$rutaCorrecta.'.php';
    }
}