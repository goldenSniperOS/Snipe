<?php namespace Snipe\Core;
/**
* Esta clase servira para otorgar los paths que se encuentran en base/paths.php
*/
class Path
{
	public static function to($path = null){
		if ($path) {
            $config = require dirname(__DIR__).DIRECTORY_SEPARATOR.'paths.php';
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