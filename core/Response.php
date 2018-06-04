<?php namespace Snipe\Core;

/**
* Esta clase es para respuestas tipo json u otros tipos de respuesta
*/
class Response
{
	public static function json($data){
		echo json_encode($data);
	}
}