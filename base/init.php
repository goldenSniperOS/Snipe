<?php

/*
  |--------------------------------------------------------------------------
  | Inicializador de Clases
  |--------------------------------------------------------------------------
  | Este script se encarga de cargar todos los archivos necesarios para el funcionamiento del framework
  | Si deseas agregar una funcion en especial puedes agregarla en la clase Tools del Core, o agregar un 
  | modulo en classes dentro de la carpeta app, automaticamente todo se incluira. No olvides colocarlo en
  | app/config/packages.php
 */
$packages = require 'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'packages.php';

if(isset($packages['modules']) && count($packages['modules']) > 0){
  foreach ($packages['modules'] as $modulo) {
    $array = glob(__DIR__.DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR.$modulo.DIRECTORY_SEPARATOR."*.php"); 
    array_multisort(array_map('strlen', $array), $array);
    foreach ($array as $filename)
    {
      require_once $filename;
    }
  }
}

spl_autoload_register(function($class) {
    //Clases del Framework
    if (file_exists('base/core/' . $class . '.php')) {
        require_once 'core/' . $class . '.php';
    }
    //Autocarga de Modelos
    if (file_exists('app/models/' . $class . '.php')) {
        require_once 'models/' . $class . '.php';
    }
});

session_start();
date_default_timezone_set(Config::get('place'));

//Inicializar el Lenguaje
Lang::init(Config::get('default_lang'));

require_once Path::to('app').DIRECTORY_SEPARATOR.'routes.php';