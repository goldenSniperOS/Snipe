<?php namespace Snipe\Core;

/**
* Esta Clase describe funciones, para mostrar valores de variables en pre
* proximamente Mostrará errores en archivos de Snipe
*/
class Debug
{
	public static function varDump($var){
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}

	public static function showSession(){
		echo '<pre>';
		var_dump($_SESSION);
		echo '</pre>';
	}

	public static function showPost(){
		echo '<pre>';
		var_dump($_POST);
		echo '</pre>';
	}

	public static function showGet(){
		echo '<pre>';
		var_dump($_GET);
		echo '</pre>';
	}
}