<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Activador de Base de Datos
	|--------------------------------------------------------------------------
	| 
	| Depende de este valor como 'true' para activar la conexion a la base o 
	| 'false' para desactivarla
	*/

	'database_activate' => 'false',

	/*
	|--------------------------------------------------------------------------
	| Conexion MySQL
	|--------------------------------------------------------------------------
	| 
	| Se colocan los parámetros de Conexion a la Base de Datos
	*/


	'mysql' => array(
			'driver' => 'mysql',
			'host' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'database' => 'mvc',
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => ''
	)
);



	