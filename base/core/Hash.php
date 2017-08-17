<?php namespace Snipe\Core;

class Hash {

    public static function make($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }

    public static function salt($lengt) {
        return utf8_encode(mcrypt_create_iv($lengt,MCRYPT_DEV_URANDOM));
    }

    public static function unique() {
        return self::make(uniqid());
    }

}
