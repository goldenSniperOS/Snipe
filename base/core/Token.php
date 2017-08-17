<?php namespace Snipe\Core;

class Token {

    public static function generate($token_name = null) {
        if ($token_name) {
            return Session::put($token_name, md5(uniqid()));
        }
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    public static function check($token, $token_name = null) {

        $tokenName = Config::get('session/token_name');

        if ($token_name) {
            $tokenName = $token_name;
        }

        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }

    public static function destroyall() {
        foreach ($_SESSION as $index => $value) {
            if (strpos($index, 'token') !== false) {
                unset($_SESSION[$index]);
            }
        }
    }

}

?>