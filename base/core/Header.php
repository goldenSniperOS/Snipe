<?php namespace Snipe\Core;
/**
* Clase para setear algunas Cabeceras de Contenido header
*/
class Header
{
	public static function allowAccess(){
		header('Access-Control-Allow-Origin: *'); 
	}

	public static function utf8(){
		header('Content-Type: text/html; charset=utf-8');
	}

}