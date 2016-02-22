<?php

//Example of routes



Route::get('function',function(){
	echo '1+1='.(1+1);
});

Route::get('/',function(){
	echo 'Snipe - PHP';
});

Route::get('home/index/{id}/{var}',function($id,$var = null){
	echo 'Hola Mundo: '.$id.'-'.$var;
});

Route::get('home/index/tema/cosa/{id}/{var}/{hola}/{mama}',function($id,$var,$hola,$var){
	echo 'Hola Mundo: '.$id.'-'.$var;
});

Route::get('test','Prueba@index');

Route::controller('restfules','Restful');

Route::post('home/index/register',function(){
	echo 'esta es una ruta post';
});