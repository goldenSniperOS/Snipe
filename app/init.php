<?php

	/*
	|--------------------------------------------------------------------------
	| Inicializador de Clases
	|--------------------------------------------------------------------------
	| 
	| Este Archivo inicializa las clases, con el primer método spl_autoload_register.
	| Si se desea incluir alguna librería de PHP, solo debes llamarla después de este método, correctamente, aqui,
	| y se cargará en toda la aplicación
	|
	*/


spl_autoload_register(function($class){
	if(file_exists('app/core/'.$class.'.php')){
		require_once 'core/'.$class.'.php';
	}

	if(Config::get('database_activate') == true){
		if(file_exists('app/models/'.$class.'.php')){
			require_once 'models/'.$class.'.php';
		}
	}
});
session_start();
require_once 'functions/sanitize.php';
require_once 'functions/assoc.php';

if(Config::get('database_activate') == false){
	include Config::path('app').'/includes/errors/nodatabase.php';
}