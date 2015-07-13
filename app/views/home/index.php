<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Snipe Framework</title>
	<?=HTML::style('css/estilos.css')?>
</head>
<body>
	<?php 
	if(Config::get('database_activate') == false){
		echo '<div id="alert"><a class="alert" href="#alert">No hay Conexion a la Base de Datos</a></div>';
	}
	?>
	<div class="logo">
		<h2>Bienvenidos a</h2>
		<h1>SnipeFramework</h1>
	</div>
</body>
</html>



