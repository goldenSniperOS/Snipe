<?php

/**
* 
*/
class Controller
{	
	function __construct()
	{	
		$paths = require __DIR__.'/../paths.php';
		foreach (glob($paths['app']."models/*.php") as $filename)
		{
		    require_once $filename;
		}
		//Las Sesiones se Inician para todos los controladores
		session_start();
	}

	protected function model($model)
	{
		$paths = require __DIR__.'/../paths.php';
		require_once $this->paths['app'].'/models/'.$model.'.php';
		return new $model();
	}

	protected function view($view,$data = [])
	{			
		$paths = require __DIR__.'/../paths.php';
		extract($data, EXTR_PREFIX_SAME, "wddx");
		require_once $paths['app'].'/views/'.$view.'.php';
	}

	
}