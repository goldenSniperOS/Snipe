<?php

class Lang {
    public static function get($key) {
        if ($path) {
            $lang = require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'locale' . DIRECTORY_SEPARATOR . Session::get('locale') . '.php';
            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }

    public static function getLang() {
        if (Session::exists('locale')) {
            $lang = require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'locale' . DIRECTORY_SEPARATOR . Session::get('locale') . '.php';
            return $lang;
        }
        return false;
    }

    public static function init($lang){
        if(!Session::exists('locale')){
          Session::put('locale',$lang);
        }
    }
    public static function setLang($lang){
        Session::put('locale',$lang);
    }
}