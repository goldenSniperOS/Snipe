<?php

class ScriptEngine 
{
	
	function __construct()
	{
		echo '<script>';
		echo 'function Snipe(){}';
		$this->defineGetRoute();
		echo '</script>';
	}

	private function defineGetRoute(){
		echo 'Snipe.route = function(route){return "'.URL::to('/').'"+route};';
	}
}