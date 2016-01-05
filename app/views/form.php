<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="<?=URL::to('home/subirdata')?>" method="post" enctype="multipart/form-data">
		<input type="file" name="archivo" id="archivo">
		<button type="submit">Enviar</button>
	</form>
</body>
</html>