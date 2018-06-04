<?php namespace Snipe\Core;

class Config {
    public static function get($path = null) {
        if ($path) {
            $config = require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR .'app'. DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'app.php';
            $path = explode('/', $path);
            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }
}