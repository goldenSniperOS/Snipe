<?php

return array(
    /*
      | This is a Copy of Laravel Paths for my Framework - GoldenSniper
      |--------------------------------------------------------------------------
      | Path de la Aplicacion
      |--------------------------------------------------------------------------
      |
      | Esta será la ruta que tendra, el acceso a toda tu aplicacion, controladores,
      | vistas, modelos, layouts y muchas cosas mas, con este, se colocaran varios paths
      | para su uso en todo el framework, es recomendable ser cuidadoso al momento de 
      | cambiarlo
      |
     */

    'app' => dirname(__DIR__).DIRECTORY_SEPARATOR.'app',
     /*
      |--------------------------------------------------------------------------
      | Public Path 
      |--------------------------------------------------------------------------
      |
      | Aqui se coloca la direccion de la
      | carpeta public para su necesidad
      |
     */
    'public' => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR. 'public' . DIRECTORY_SEPARATOR,
    /*
      |--------------------------------------------------------------------------
      | Base Path
      |--------------------------------------------------------------------------
      |
      | The base path is the root of the Laravel installation. Most likely you
      | will not need to change this value. But, if for some wild reason it
      | is necessary you will do so here, just proceed with some caution.
      |
     */
    'base' => ((isset($_SERVER['HTTPS']))?'https':'http').'://' . $_SERVER['HTTP_HOST'] . str_replace('/index.php', '', $_SERVER['PHP_SELF'])
);