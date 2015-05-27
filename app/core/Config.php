<?php 
class Config
{
	public static function get($path=null){
		if($path){
			$config = require __DIR__.'/../config/app.php';
			$path = explode('/',$path);
			foreach ($path as $bit) {
				if(isset($config[$bit])){
					$config = $config[$bit];
				}
			}
			return $config;
		}
		return false;
	}
	public static function path($path=null){
		if($path){
			$config = require __DIR__.'/../config/paths.php';
			$path = explode('/',$path);
			foreach ($path as $bit) {
				if(isset($config[$bit])){
					$config = $config[$bit];
				}
			}
			return $config;
		}
		return false;
	}
}

?>