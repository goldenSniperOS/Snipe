<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta id="viewport" name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $this->e($title) ?> </title>
   
  <?= link_tag("img/favicon.ico", ['rel'=>"shortcut icon" ,'type'=>"image/ico" ]) ?>
  <?= style("css/style.css") ?>

  <?=$this->section('styles')?>

</head>
<body>
  <div>
    <?=$this->section('content')?>
  </div>
  
  <?= script("js/jquery.min.js") ?>
  <?= script("js/script.js") ?>

  <?=$this->section('scripts')?>
</body>