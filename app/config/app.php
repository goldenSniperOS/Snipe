<?php
return array(

	/*
	|--------------------------------------------------------------------------
	| Activador de Base de Datos
	|--------------------------------------------------------------------------
	| 
	| Depende de este valor como 'true' para activar la conexion a la base o 
	| 'false' para desactivarla
	|
	*/

	'database_activate' => false ,
	/*
	|--------------------------------------------------------------------------
	| Conexion MySQL
	|--------------------------------------------------------------------------
	| 
	| Se colocan los parámetros de Conexion a la Base de Datos
	|
	*/
	'mysql' => array(
			'host' => '127.0.0.1',
			'username' => 'root',
			'password' => '',
			'database' => 'snipe_database',
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => ''
	),
	/*
	|--------------------------------------------------------------------------
	| Cookies
	|--------------------------------------------------------------------------
	| 
	| Se Utilizan para saber cual es el nombre de la cookie que generará
	| Por Cada Usuario Logueado, y su Tiempo de expiración
	|
	*/
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),

	/*
	|--------------------------------------------------------------------------
	| Variables de Sesión
	|--------------------------------------------------------------------------
	| 
	| Se utiliza para conocer el nombre de el Token de Formulario
	| Y el nombre de la variable de sesion que mantiene el hash del usuario logueado
	|
	*/
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);



	