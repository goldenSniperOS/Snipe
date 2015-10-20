<?php
if (Session::exists('errores')) {
    $errores = Session::flash('errores');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once Config::path('app') . '/themes/includes/meta.php'; ?>
        <?php require_once Config::path('app') . '/themes/layouts/profile/head.php'; ?>
    </head>
    <body>
        <div id="wrapper">
            <?php require_once $content; ?>            
        </div>
        <?php require_once Config::path('app') . '/themes/layouts/profile/scripts.php'; ?>
    </body>
</html>