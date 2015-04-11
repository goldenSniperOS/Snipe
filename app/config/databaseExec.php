<?php

use Illuminate\Database\Capsule\Manager as Capsule;
	
	$data = require __DIR__.'database.php';
	
	$capsule = new Capsule();

	if($data['database_activate'] == 'true')
	{	
		$capsule->addConnection($data['mysql']);
		$capsule->setAsGlobal();
		$capsule->bootEloquent();
	}

	