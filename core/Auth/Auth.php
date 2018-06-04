<?php namespace Snipe\Core;


class Auth {

    public static function get($attribute = null) {
        if ($attribute) {
            if (Session::exists(Config::get('session/session_name'))) {
                $user = Session::get(Config::get('session/session_name'));
                if ($user) {
                    if (property_exists($user, $attribute)) {
                        return $user->{$attribute};
                    }
                }
            }
        }
        return null;
    }

    public static function login($username = null, $password = null) {
        if ($username != null && $password != null) {
            $class = Config::get('user/user_class');
            if(Config::get('user/hash_active')){
                $user = $class::find($username, Config::get('user/userField'));
                if ($user != null) {
                    if ($user->{Config::get('user/passwordField')} === Hash::make($password,$user->{Config::get('user/saltField')})) {
                        //Estas Dos Lineas Loguean realmente al Usuario         
                        Session::put(Config::get('session/session_name'), $user);
                        Session::put('isLoggedIn', true);
                        return true;
                    }
                }
            }else{
                $user = $class::where(Config::get('user/userField'),$username)
                ->where(Config::get('user/passwordField'),$password)
                ->first();
                 if ($user != null) {
                    //Estas Dos Lineas Loguean realmente al Usuario         
                    Session::put(Config::get('session/session_name'), $user);
                    Session::put('isLoggedIn', true);
                    return true;
                }
            }
            
        }
        return false;
    }

    public static function logout() {
        Session::destroy();
    }

    public function isNotLoggedIn() {
        if (Session::exists('isLoggedIn')) {
            return false;
        }
        return true;
    }

    public function isLoggedIn() {
        if (Session::exists('isLoggedIn')) {
            return true;
        }
        return false;
    }

}
