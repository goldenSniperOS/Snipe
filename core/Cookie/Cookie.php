<?php namespace Snipe\Core;


class Cookie {

    public static function exists($name) {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    public static function get($name) {
        return $_COOKIE[$name];
    }

    public static function put($name, $value, $expiry = null) {
        if(is_null($expiry)){
            $expiry = Config::get('cookies/default_cookie_expiry');
        }
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    public static function delete($name) {
        self::put($name, '', time() - 1);
    }

}
