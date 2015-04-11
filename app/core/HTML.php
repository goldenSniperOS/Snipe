<?php

/**
* 
*/
class HTML
{
	
	public function image($normalpath)
	{
		$paths = require __DIR__.'/../paths.php';
		echo "<img src='".$paths['public']."/".$normalpath."'>";
	}

	public function style($normalpath)
	{
		$paths = require __DIR__.'/../paths.php';
		echo "<link rel='stylesheet' type='text/css' href='".$paths['public']."/".$normalpath."'>";
	}

	public function script($normalpath)
	{
		$paths = require __DIR__.'/../paths.php';
		echo "<script type='text/javascript' src='".$paths['public'].$normalpath."'></script>";
	}	
}