<?php

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

    public static function login($username = null, $password = null, $remember = null) {
        if ($username != null && $password != null) {
            $class = Config::get('user/user_class');
            $user = $class::find($username, Config::get('user/userField'));
            if ($user != null) {
                if ($user->{Config::get('user/passwordField')} === Hash::make($password,$user->salt)) {
                    //Estas Dos Lineas Loguean realmente al Usuario			
                    Session::put(Config::get('session/session_name'), $user);
                    Session::put('isLoggedIn', true);

                    //Las Sesiones los Grupos y Permisos Solo funcionan con la Plataforma de Usuarios Integrada
                    if(Config::get('user-platform')){                       
                        //Verificar si tiene una sesion habilitada                       
                        $hashCheck = SessionModel::find($user->id,'user_id');
                        if ($hashCheck == null) {
                            $hash = Hash::unique();
                            SessionModel::create([
                                Config::get('session/primaryKey') => $user->{$user->getInfo('primaryKey')},
                                Config::get('session/hashField') => $hash
                            ]);
                        } else {
                            $hash = $hashCheck->{Config::get('session/hashField')};
                        }
                        Cookie::put(Config::get('remember/cookie_name'), $hash, Config::get('remember/cookie_expiry'));
                    }
                    
                    return true;
                }
            }
        }
        return false;
    }

    public static function logout() {
        if (Session::exists(Config::get('session/session_name')) && Config::get('session/activeDatabase')) {
            $user = Session::get(Config::get('session/session_name'));
            if ($user) {
                DB::getInstance()->delete(Config::get('session/table'), [
                    [Config::get('session/primaryKey'), '=', $user->{$user->getInfo('primaryKey')}]
                ]);
            }
        }
        Session::delete('isLoggedIn');
        if (Config::get('groups/activeDatabase')) {
            Session::delete('listPermission');
        }
        Session::delete(Config::get('session/session_name'));
        Cookie::delete(Config::get('remember/cookie_name'));
    }

    public static function updatePermissions() {
        if (Session::exists('isLoggedIn') && Session::exists(Config::get('session/session_name') && Config::get())) {
            $user = Session::get(Config::get('session/session_name'));
            $permission = json_decode($user->permissions);
            if (property_exists($user, $foreignGroup)) {
                if ($user && Config::get('groups/active')) {
                    $grupo = DB::getInstance()->table(Config::get('groups/table'))->where(Config::get('groups/primaryKey'), $user->{$foreignGroup})->first();
                    Session::put('listPermission', json_decode($grupo->{Config::get('groups/permissionField')}));
                }
            }
        }
        return false;
    }

    public function hasPermission($key = null) {
        if (Config::get('user-platform')) {
            if (Session::exists('listPermission')) {
                if (property_exists(Session::get('listPermission'), $key)) {
                    return Session::get('listPermission')->{$key};
                }
            }
            return false;
        }
        return true;
    }

    public function isLoggedIn() {
        if (Session::exists('isLoggedIn')) {
            return Session::get('isLoggedIn');
        } else {
            if (Cookie::exists(Config::get('remember/cookie_name'))) {
                $hashCheck = DB::getInstance()
                        ->table(Config::get('session/table'))
                        ->where(Config::get('session/hashField'), '=', Cookie::get(Config::get('remember/cookie_name')))
                        ->first();
                if ($hashCheck) {
                    $class = Config::get('user/user_class');
                    $user = $class::find($hashCheck->{Config::get('session/primaryKey')});
                    Session::put('isLoggedIn', true);
                    Session::put(Config::get('session/session_name'), $user);
                    if (Config::get('groups/active')) {
                        Session::put('listPermission', self::getPermissions($user));
                    }
                    return Session::get('isLoggedIn');
                } else {
                    Cookie::delete(Config::get('remember/cookie_name'));
                }
            }
        }
        return false;
    }

}
