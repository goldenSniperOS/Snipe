<?php
if (Session::exists('errores')) {
    $errores = Session::flash('errores');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php View::add('includes/meta',$meta);?>
        <?php View::add('layouts/home/head');?>
    </head>
    <body>
        <div id="wrapper">
            <?php View::content($content)?>
        </div>
        <?php View::add('layouts/home/scripts');?>
    </body>
</html>