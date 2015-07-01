<?php
class View{
	public static function render($view,$data = []){
		extract($data, EXTR_PREFIX_SAME, "wddx");
		require_once Config::path('app').DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$view.'.php';
	}
}