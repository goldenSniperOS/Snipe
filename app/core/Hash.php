<?php

class Hash {

    public static function make($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }

    public static function salt($lengt) {
        return mcrypt_create_iv($lengt);
    }

    public static function unique() {
        return self::make(uniqid());
    }

}
