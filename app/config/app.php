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
	'database_activate' => false,
	/*
	|--------------------------------------------------------------------------
	| Activador de Errores Base de Datos
	|--------------------------------------------------------------------------
	| 
	| Depende de este valor como 'true' o 'false' para activar los avisos de 
	| errores en alguna consulta o cualquier error referente a la base de datos
	|
	*/
	'database_errors' => false,
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
			'database' => 'database',
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
	| Variables de Sesión - Tabla de Sesiones en Base de Datos - Recordar Siempre
	|--------------------------------------------------------------------------
	| 
	| Se utiliza para conocer el nombre de el Token de Formulario
	| Y el nombre de la variable de sesion que mantiene el hash del usuario logueado,
	| Si activeDatabase esta desactivado, la sesión termina en el tiempo que una sesión
	| termina por defecto en la configuración de PHP
	|
	*/
	'session' => array(
		'activeDatabase' => false,
		'session_name' => 'user',
		'token_name' => 'token',
		'table' => 'tbsesion',
		'prefix' => 'SES',
		'primaryKey' => 'ses_per_Codigo',
		'hashField' => 'ses_Hash'
	),
	/*
	|--------------------------------------------------------------------------
	| Grupos de Usuarios por Permiso
	|--------------------------------------------------------------------------
	| Esta tabla Identifica a los Usuarios por permiso, para reservar areas de administrador
	| o usuario cliente sea el caso necesario, Si activeDatabase esta deshabilitado todos tienen
	| El permiso de Administrador
	|
	*/
	'groups' => array(
		'activeDatabase' => true,
		'table' => 'tbgrupos',
		'prefix' => 'GRU',
		'primaryKey' => 'grupo_Codigo',
		'permissionField' => 'grupo_Permisos',
	),
	/*
	|--------------------------------------------------------------------------
	| Clase de Usuarios
	|--------------------------------------------------------------------------
	| Selecciona el nombre del Modelo que llevara el control de los Usuarios y Los nombres
	| de las Variables de Sesion que contienen la lista de Permisos y Si el usuario esta 
	| Logueado o no
	*/
	'user' => [
		'user_class' => 'Persona',
		'userField' => 'per_Usuario',
		'passwordField' => 'per_Contrasena',
		'nameLogguedIn' => 'isLogguedIn',
		'nameListPermission' => 'listPermission'
	]
);



	