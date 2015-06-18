<?php
class Home extends Controller
{
	public function index()
	{
		$this->view('home/index');
	}

	public function otra()
	{	
		$this->view('home/plantilla');
	}
}