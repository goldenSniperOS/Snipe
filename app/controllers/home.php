<?php
class Home
{
	public function index()
	{
		View::render('home/index');
	}

	public function otra()
	{	
		View::render('home/plantilla');
	}

	public function test(){
		echo '<pre>';
		//DB::getInstance()->table('consulta')->where('id',18)->update(['Receta' => 'Todo','Observacion' => 'En Todo']));
		echo '</pre>';
		//die();
		echo '<pre>';
		//DB::getInstance()->table('consultorio')->insert(['Nombre'=>'Consultorio Medico Registro 2']);
		echo '</pre>';
		echo '<pre>';
		//var_dump(DB::getInstance()->table('consultorio')->where('id',18)->delete());
		echo '</pre>';
		Consultorio::create(['Nombre'=>'Consultorio Medico Registro 2']);
		echo '<pre>';
		var_dump(DB::getInstance()->table('consultorio')->get());
		echo '</pre>';
	}
}
