<?php
class Route{

	private static function setRoute($method,$route,$function){
		$params = [];
		//Sacamos los Parametros
		preg_match_all("/\{(.*?)\}/", $route, $params);
		//Extraemos la Ruta Final
		$rutaFinal = explode('/', filter_var(rtrim($route, '/'), FILTER_SANITIZE_URL));
		$literales = array_slice($rutaFinal,0,count($rutaFinal) - count($params[1]));
		App::addRoute([
			'literal' => $route,
			'type' => $method,
			'route' => $literales,
			'params' => $params[1],
			'function' => $function
		]);
	}
	
	public static function get($route,$function){
		self::setRoute('get',$route,$function);
	}

	public static function post($route,$function){
		self::setRoute('post',$route,$function);
	}

	public static function controller($route,$controller){
		self::setRoute('controller',$route,$controller);
	}

}