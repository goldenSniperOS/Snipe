<?php


return array(
    /*
      |--------------------------------------------------------------------------
      | Lenguaje por defecto
      |--------------------------------------------------------------------------
      |
      | Esta opcion, setea por defecto el lenguaje del sistema segun los archivos que estan en
      | la carpeta locale.
      |
     */
    'default_lang' => 'en',
    /*
      |--------------------------------------------------------------------------
      | Activador de Errores Base de Datos
      |--------------------------------------------------------------------------
      |
      | Depende de este valor como 'true' o 'false' para activar los avisos de
      | errores en alguna consulta o cualquier error referente a la base de datos
      |
     */
    'database_errors' => true,
     /*
      |--------------------------------------------------------------------------
      | Activador de Errores en PHP
      |--------------------------------------------------------------------------
      |
      | Algunas configuraciones iniciales del php.ini hacen que cualquier error de
      | PHP se vea como un error 500 en un servidor, impidiendo ver los errores del
      | código. Si este tiene el valor true, mostrará los errores de php.
      |
     */
    'debug' => true,
    /*
      |--------------------------------------------------------------------------
      | Zona Horaria en la Aplicación
      |--------------------------------------------------------------------------
      |
      | Con esta línea podemos setear la localidad en la que funcionará la aplicación,
      | para asi setear la hora en la que funcionará y retorno de la funcion date()
      |
     */
    'place' => 'America/Lima',
    /*
      |--------------------------------------------------------------------------
      | Conexion MySQL
      |--------------------------------------------------------------------------
      |
      | Se colocan los parámetros de Conexion a la Base de Datos
      |
     */
    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'database',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ],
    /*
      |--------------------------------------------------------------------------
      | Cookies
      |--------------------------------------------------------------------------
      |
      | Se Utilizan para saber cual es el nombre de la cookie que generará
      | Por Cada Usuario Logueado, y su Tiempo de expiración
      |
     */
    'cookies' => [
        'default_cookie_expiry' => 604800
    ],
    /*
      |--------------------------------------------------------------------------
      | Variables de Sesión de Usuario
      |--------------------------------------------------------------------------
      |
      | Estas variables de sesion contienen: La variable donde se almacenarán los datos,
      | del usuario logueado y el token generado por Token::generate() dentro de un formulario.
      | Se recomienda no alterarlas
      |
     */
    'session' => [
        'session_name' => 'user',
        'token_name' => 'token',
    ],

    /*
      |--------------------------------------------------------------------------
      | Clase de Usuarios
      |--------------------------------------------------------------------------
      | Selecciona el nombre del Modelo que llevara el control de los Usuarios y Los nombres
      | de las Variables de Sesion que contienen la lista de Permisos y Si el usuario esta
      | Logueado o no. La opcion hash active, determina si el sistema de encriptacion sera por
      | hash o no, y si este fuera, deberia tener un campo extra llamado salt. Si no es asi, el
      | logueo de usuario sera por campo usuario y contraseña
     */
    'user' => [
        'hash_active' => true,
        'user_class' => 'UsersModel',
        'userField' => 'username',
        'passwordField' => 'password',
        'saltField' => 'salt',
    ],
);