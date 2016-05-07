<?php

//Example of routes

//Ruta Inicial del Proyecto
Route::get('/',function(){
	View::render('home/index');
});

Route::get('function',function(){
	//Puedes definir rutas con nombres diferentes
});


Route::post('user/register',function(){
	//Puedes definir rutas de tipo POST
});

Route::get('home/index/{id}/{var}',function($id,$var = null){
	//Si deseas que un parametro sea obligatorio solo debes poner null a la variable
	echo 'Ruta con Parametros: '.$id.'-'.$var;
});

//Ruta asignada a controlador y funcion
Route::get('test','Prueba@index');

//Controlador RestFul asignado a una ruta
Route::controller('restfules','Restful');
