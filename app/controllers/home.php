<?php

	/*
	|--------------------------------------------------------------------------
	| Ejemplo de Controlador - Controlador Principal Home
	|--------------------------------------------------------------------------
	| 
	| Este controlador es el controlador por defecto al igual que, su método index.
	| El Controlador Home y el método index son obligatorios en la Aplicación, y este 
	| último, es obligatorio en todos los controladores, debido a que se ejecutara por
	| defecto si no se le coloca otra función que se declare
	|
	*/

class Home
{
	public function index()
	{
		View::render('home/index');
	}

	public function plantilla()
	{	
		View::render('home/plantilla');
	}

}
