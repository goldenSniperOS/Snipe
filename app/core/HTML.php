<?php
class HTML{	
	public function image($normalpath,$attrib = []){
		$stringFinal = "<img src='".Config::path('public').'/'.$normalpath."'";
		foreach ($attrib as $key => $value) {
			$stringFinal .= " ".$key."='".$value."'";
		}
		return $stringFinal.">";
	}

	public function style($normalpath){
		echo "<link rel='stylesheet' type='text/css' href='".Config::path('public').'/'.$normalpath."'>";
	}

	public function script($normalpath){
		return "<script type='text/javascript' src='".Config::path('public').'/'.$normalpath."'></script>";
	}	
}