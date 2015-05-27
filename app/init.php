<?php
	spl_autoload_register(function($class){
		require_once 'core/'.$class.'.php';
	});

	if(Config::get('database_activate') == true){
		spl_autoload_register(function($model){
			require_once 'models/'.$model.'.php';
		});	
	}else{
		echo '<p>No hay Conexion a la Base de Datos</p>';
	}
	
	