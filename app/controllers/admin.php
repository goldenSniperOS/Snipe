<?php

class Admin {

    public function index() {
        $layout = "admin";
        $meta = array(
            'title' => 'Administrador',
            'description' => 'El mejor framework creado para ayudar a nuestros usuarios a construir sus webs.',
            'keywords' => 'php, framework, mvc, cms',
            'author' => 'Snipe Framework Group',
            'robots' => 'All'
        );
        View::render('admin/index', ['meta' => $meta], $layout);
    }

}
