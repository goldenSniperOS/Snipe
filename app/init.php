<?php
spl_autoload_register(function($class){
	if(file_exists('app/core/'.$class.'.php')){
		require_once 'core/'.$class.'.php';
	}

	if(Config::get('database_activate') == true){
		if(file_exists('app/models/'.$class.'.php')){
			require_once 'models/'.$class.'.php';
		}
	}else{
		echo '<p>No hay Conexion a la Base de Datos</p>';
	}
});
session_start();
require_once 'functions/sanitize.php';