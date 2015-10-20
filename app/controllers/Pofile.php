<?php

class Profile {

    public function index() {
        $layout = "profile";
        $meta = array(
            'title' => 'Profile',
            'description' => 'El mejor framework creado para ayudar a nuestros usuarios a construir sus webs.',
            'keywords' => 'php, framework, mvc, cms',
            'author' => 'Snipe Framework Groups.',
            'robots' => 'All'
        );
        View::render('profile/index', ['meta' => $meta], $layout);
    }

}
