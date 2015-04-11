<?php
/**
* 
*/
class Home extends Controller
{
	public function index()
	{
		if(empty($_SESSION['status']))
		{
			$_SESSION['status'] = '';		
		}

		$name = User::find(1)->username;
		$this->view('home/index',['name' => $name,'status'=> $_SESSION['status']]);
		$_SESSION['status'] = '';
	}

	public function create()
	{
		$usuario = new User;
		$usuario->username = $_POST['username'];
		$usuario->email = $_POST['email'];
		$usuario->save();
		
		//Variables de Sesion a Nivel de Todo el Proyecto
		$_SESSION['status'] = 'ok';

		//Redireccion
		header('Location: '.URL::to('home'));
		
	}
	public function probarglobales()
	{
		echo __DIR__;		
	}

	function __construct() {
		parent::__construct();
		//echo 'Hello This is the index';
		//Validations
	}
	
}