<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Activador de Base de Datos
      |--------------------------------------------------------------------------
      |
      | Depende de este valor como 'true' para activar la conexion a la base o
      | 'false' para desactivarla
      |
     */
    'database_activate' => true,
    /*
      |--------------------------------------------------------------------------
      | Excepción de Clases en El Autoloader
      |--------------------------------------------------------------------------
      |
      | En este Array puedes colocar, las clases que no desees considerar en el Autoloader.
      | Colocando un * delante el nombre de la clase, no se agregarán todas las que contengan,
      | ese nombre
      |
     */
    'class_exceptions' => [],
    /*
      |--------------------------------------------------------------------------
      | Activador de Errores Base de Datos
      |--------------------------------------------------------------------------
      |
      | Depende de este valor como 'true' o 'false' para activar los avisos de
      | errores en alguna consulta o cualquier error referente a la base de datos
      |
     */
    'database_errors' => false,
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
    'remember' => [
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ],
    /*
      |--------------------------------------------------------------------------
      | Variables de Sesión - Tabla de Sesiones en Base de Datos - Recordar Siempre
      |--------------------------------------------------------------------------
      |
      | Se utiliza para conocer el nombre de el Token de Formulario
      | Y el nombre de la variable de sesion que mantiene el hash del usuario logueado,
      | Si active esta desactivado, la sesión termina en el tiempo que una sesión
      | termina por defecto en la configuración de PHP
      |
     */
    'session' => [
        'session_name' => 'user',
        'token_name' => 'token',
    ],
    /*
      |--------------------------------------------------------------------------
      | Plataforma de Usuarios integrada
      |--------------------------------------------------------------------------
      | Snipe tiene una plataforma de usuarios incluida, para cualquier tipo de aplicación que necesites, 
      | si deseas usarla puedes colocarle true a a la variable o false, si deseas implementar tu propia 
      | plataforma. Esta plataforma le dará mantenimiento a todos los usuarios.
     */
    'user-platform' => true,
    /*
      |--------------------------------------------------------------------------
      | Clase de Usuarios
      |--------------------------------------------------------------------------
      | Selecciona el nombre del Modelo que llevara el control de los Usuarios y Los nombres
      | de las Variables de Sesion que contienen la lista de Permisos y Si el usuario esta
      | Logueado o no
     */
    'user' => [
        'user_class' => 'UsersModel',
        'userField' => 'username',
        'passwordField' => 'password',
    ],
);



