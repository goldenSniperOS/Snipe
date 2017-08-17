<?php namespace Snipe\Core;

class ScriptEngine
{

	function __construct()
	{
		echo '<script>';
		echo 'function Snipe(){}';
		$this->defineGetRoute();
		$this->defineallSession();
		echo '</script>';
	}

	private function defineGetRoute(){
		echo 'Snipe.route = function(route){return "'.URL::to('/').'"+route};';
	}

	private function defineallSession(){
		echo 'var SessionData = '. json_encode($_SESSION).';';
		echo 'Snipe.sessions = function(literal){';
		echo 'if(SessionData.hasOwnProperty(literal)){return SessionData[literal];}else{return SessionData;}';
		echo '}';
	}
}
