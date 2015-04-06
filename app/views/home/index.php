<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>First Page Of Index</title>
	<?=HTML::style('css/estilos.css')?>
</head>
<body>
	<?php 
		if($_SESSION['status'] == 'ok')
		{
			echo 'El Usuario fue creado correctamente';
		}
	?>

	<form action="<?=URL::to('home/create')?>" method="post">
		<input type="text" name="username">
		<input type="text" name="email">
		<input type="submit" value="Enviar">
	</form>	
</body>
</html>



