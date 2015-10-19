<?php

class View {

    public static function render($view, $data = [], $layout = null) {
        extract($data, EXTR_PREFIX_SAME, "wddx");
        $content = Config::path('app') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
        require_once Config::path('app') . DIRECTORY_SEPARATOR . 'themes/layouts' . DIRECTORY_SEPARATOR . $layout . '.php';
    }

}
