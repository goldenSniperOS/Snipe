<?php

/**
* 
*/
class HTML{
	
	public function image($normalpath)
	{
		return "<img src='".Config::path('public')."/".$normalpath."'>";
	}

	public function style($normalpath)
	{
		echo "<link rel='stylesheet' type='text/css' href='".Config::path('public')."/".$normalpath."'>";
	}

	public function script($normalpath)
	{
		return "<script type='text/javascript' src='".Config::path('public').$normalpath."'></script>";
	}	
}