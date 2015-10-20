<?php

class Users {

    public function login_op() {
        $equivalence = Input::get('process');
        if (Input::exists()) {
            if (Token::check(Input::get('token_form'))) {
                $validate = new Validate();
                $validation = $validate->check($_POST, [
                    'username' => [
                        'required' => true
                    ],
                    'password' => [
                        'required' => true
                    ]
                ]);
                if ($validation->passed()) {
                    if ($equivalence === "login") {
                        $login = Auth::login(Input::get('username'), Input::get('password'));
                        if ($login) {
                            Redirect::to('profile/index');
                        } else {
                            Session::flash('login', array(
                                'message' => 'Usuario o Passwords Incorrectos!',
                                'class' => 'danger'
                            ));
                            Redirect::to('home/login');
                        }
                    }
                } else {
                    Session::flash('errores', $validation->errors());
                    Redirect::to('home/login/' . $equivalence . $get_id);
                }
            } else {
                Redirect::to('home/login');
            }
        } else {
            Redirect::to('home/login/');
        }
    }
    
    public function logout() {
        Auth::logout();
        Redirect::to('home/index');
    }

    public function register_op() {
        $equivalence = Input::get('process');
        if (Input::exists()) {
            if (Token::check(Input::get('token_form'))) {
                $validate = new Validate();
                $validation = $validate->check($_POST, [
                    'name' => [
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                    ],
                    'lastname' => [
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                    ],
                    'email' => [
                        'required' => true,
                        'min' => 4,
                        'max' => 30
                    ],
                    'username' => [
                        'required' => true,
                        'min' => 4,
                        'max' => 30
                    ],
                    'password' => [
                        'required' => true,
                        'min' => 6,
                        'max' => 10
                    ],
                    'password_again' => [
                        'required' => true,
                        'matches' => 'password'
                    ]
                ]);
                if ($validation->passed()) {
                    if ($equivalence === "register") {
                        $salt = Hash::salt(32);
                        UsersModel::create([
                            'enable' => 1,
                            'id_profiles' => 1,
                            'buy' => Input::get('buy'),
                            'sale' => Input::get('sale'),
                            'name' => Input::get('name'),
                            'lastname' => Input::get('lastname'),
                            'email' => Input::get('email'),
                            'username' => Input::get('username'),
                            'password' => Hash::make(Input::get('password')),
                            'newsletter' => Input::get('newsletter'),
                            'facebook_enable' => 0,
                            'twitter_enable' => 0,
                            'instagram_enable' => 0,
                            'linkedin_enable' => 0,
                            'skype_enable' => 0,
                            'salt' => $salt,
                            'status' => 0,
                            'token' => Input::get('token_form'),
                            'joined' => date('Y-m-d H:i:s')
                        ]);
                    }

                    Redirect::to('home/index');
                } else {
                    Session::flash('errores', $validation->errors());
                    Redirect::to('home/register/' . $equivalence . $get_id);
                }
            } else {
                Redirect::to('home/register');
            }
        } else {
            Redirect::to('home/register/' . $equivalence . $get_id);
        }
    }
    
}
