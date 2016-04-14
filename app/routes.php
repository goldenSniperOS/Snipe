<?php

//Example of routes

//Ruta inicial del proyecto
Route::get('/',function(){
	$prueba = DB::getInstance()->where(function($query){

	})->where('var','pene');
	Debug::varDump($prueba);
});

Route::get('function',function(){
	//Se ejecuta con http//localhost/project/function

});

Route::post('user/register',function(){
	echo 'Esta es una ruta POST';
});

Route::get('home/index/{id}/{var}',function($id,$var = null){
	//Si deseas que un parametro sea obligatorio solo debes poner null a la variable
	echo 'Ruta con Parametros: '.$id.'-'.$var;
});

//Asignado a controlador y función
Route::get('test','Prueba@index');

//Controlador RestFul asignado a una ruta
Route::controller('restfules','Restful');
