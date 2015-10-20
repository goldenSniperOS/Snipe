<div class="logo">
    <h2>Bienvenidos a Home</h2>
    <h1>SnipeFramework</h1>
    <?php echo _("Hello"); ?>
</div>

<form name="myform" method="post">
    <select name="locale" onchange="myform.submit();">
        <option value="en" <?php if ($_COOKIE['locale'] == "en") echo "selected='selected' " ?> >English</option>
        <option value="fr" <?php if ($_COOKIE['locale'] == "fr") echo "selected='selected' " ?> >Français</option>
    </select>  
</form>

<?php if (Auth::isLoggedIn()) { ?>
    <a href="<?= URL::to('profile') ?>" class="btn btn-lg btn-danger">Profile</a>
    <a href="<?= URL::to('admin') ?>" class="btn btn-lg btn-danger">Admin</a>
    <a href="<?= URL::to('users/logout') ?>" class="btn btn-lg btn-danger">logout </a>
<?php } else { ?>
    <a href="<?= URL::to('home/login') ?>" class="btn btn-lg btn-danger">Login</a>
    <a href="<?= URL::to('home/register') ?>" class="btn btn-lg btn-danger">Register</a>
<?php } ?>






