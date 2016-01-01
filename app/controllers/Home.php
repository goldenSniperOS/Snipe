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

class Home {
    public function index() {
        $layout = "home";
        $meta = array(
            'title' => 'Home',
            'description' => 'El mejor framework creado para ayudar a nuestros usuarios a construir sus webs.',
            'keywords' => 'php, framework, mvc, cms',
            'author' => 'Snipe Framework Group.',
            'robots' => 'All'
        );
        View::render('home/index', ['meta' => $meta], $layout);
    }

    public function testUsers(){
      $salt = Hash::salt(32);
      $id = UsersModel::create([
        'username' => 'goldensniper',
        'salt' => $salt,
        'password' => Hash::make('admin123',$salt),
      ]);

      print 'El primero '.$id;

      $salt = Hash::salt(32);
      $id = UsersModel::create([
        'username' => 'anguelsc',
        'salt' => $salt,
        'password' => Hash::make('Losmejores',$salt),
      ]);
      print 'El segundo '.$id;
    }

    public function testUpdate(){    
      $salt = Hash::salt(32);
      UsersModel::update([
        'salt' => $salt,
        'password' => Hash::make('clave2',$salt),
      ],2);
    }

    public function testeo(){
      $var = UsersModel::select('username','password');
      echo '<pre>';
      var_dump($var);
      echo '<pre>';
    }
}
