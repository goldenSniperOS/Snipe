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

}
