<?php

class URL
{
	public function to($normalpath)
	{
		return Config::path('public').$normalpath;
	}
}