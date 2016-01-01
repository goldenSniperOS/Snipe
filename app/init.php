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
$packages = require 'app/config/packages.php';
spl_autoload_register(function($class) {
    $packages = require 'app/config/packages.php';
    if (count($packages['modules']) != 0) {
        foreach ($packages['modules'] as $clase) {
            if (!strpos($clase, $class) !== false) {
                if (file_exists('app/core/' . $class . '.php')) {
                    require_once 'core/' . $class . '.php';
                }
            }
        }
    } else {
        if (file_exists('app/core/' . $class . '.php')) {
            require_once 'core/' . $class . '.php';
        }
    }


    if (Config::get('database_activate') == true) {
        if (file_exists('app/models/' . $class . '.php')) {
            require_once 'models/' . $class . '.php';
        }
    }
});

if(count($packages['modules']) > 0){
  foreach ($packages['modules'] as $modulo) {
    //echo $modulo;
    foreach (glob("app/classes/".$modulo."/*.php") as $filename)
    {
      require_once $filename;
    }
  }
}

session_start();

require_once 'functions/sanitize.php';
require_once 'functions/assoc.php';
require_once 'functions/locale.php';


//Zona En Reparacion Guillermo -
/*if (isset($_GET['locale'])) {
    $lang = $_GET['locale'];
    $_SESSION['locale'] = $lang;
    setcookie("locale", $lang, time() + (3600 * 24 * 30));
} else if (isset($_POST["locale"])) {
    $lang = $_POST['locale'];
    $_SESSION['locale'] = $lang;
    setcookie("locale", $lang, time() + (3600 * 24 * 30));
}else if (isset($_SESSION['locale'])) {
    $lang = $_SESSION['locale'];
} else if (isset($_COOKIE['locale'])) {
    $lang = $_COOKIE['locale'];
} else {
    $lang = 'es';
}

setLocalization($lang);*/


date_default_timezone_set(Config::get('place'));
if (Config::get('database_activate') == false) {
    include Config::path('app') . '/includes/errors/nodatabase.php';
}