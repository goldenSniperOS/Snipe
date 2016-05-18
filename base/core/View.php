<?php
class View {
    public static function render($view, $data = [], $layout = null) {
        extract($data, EXTR_PREFIX_SAME, "wddx");
        //Scripts Generales para tener Datos del Framework en Javascript
        $script =  new ScriptEngine();
        $content = Path::to('app') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
        if($layout){
        	require_once Path::to('app') . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $layout . '.php';
        }else{
        	require_once $content;
        }
    }

    public static function add($route,$data = []){
        extract($data, EXTR_PREFIX_SAME, "wddx");
        $rutas = explode('/', $route);
        $rutaCorrecta = implode(DIRECTORY_SEPARATOR,$rutas);
    	require_once Path::to('app') .DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.$rutaCorrecta.'.php';
    }
}