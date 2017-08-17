<?php namespace Snipe\Core;

/**
* Esta clase es para respuestas tipo json u otros tipos de respuesta
*/

class Response
{
	public static function json( $data ){
		header('Content-type: application/json');
		print_r( json_encode($data) );
	}
}