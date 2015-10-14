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

$configure = include 'config'.DIRECTORY_SEPARATOR.'app.php';
$configurePath = include 'config'.DIRECTORY_SEPARATOR.'paths.php';

spl_autoload_register(function($class){
	$configure = include 'config'.DIRECTORY_SEPARATOR.'app.php';
	if(count($configure['class_exceptions']) != 0){
		foreach ($configure['class_exceptions'] as $clase) {
			if(!strpos($clase,$class) !== false){
				if(file_exists('app/core/'.$class.'.php')){
					require_once 'core/'.$class.'.php';
				}
			}
		}	
	}else{
		if(file_exists('app/core/'.$class.'.php')){
			require_once 'core/'.$class.'.php';
		}
	}
	

	if($configure['database_activate'] == true){
		if(file_exists('app/models/'.$class.'.php')){
			require_once 'models/'.$class.'.php';
		}
	}
});
session_start();
require_once 'functions/sanitize.php';
require_once 'functions/assoc.php';
date_default_timezone_set($configure['place']);
if($configure['database_activate'] == false){
	include $configurePath['app'].'/includes/errors/nodatabase.php';
}