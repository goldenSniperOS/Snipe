<?php

class URL
{
	public function to($normalpath)
	{
		$paths = require __DIR__.'/../paths.php';
		return $paths['public'].$normalpath;
	}
}