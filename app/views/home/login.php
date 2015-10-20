<?php
if (Session::exists('login')) {
    $value = Session::flash('login');
}
?>
<?php if (isset($value)): ?>
    <div class="alert alert-<?= $value['class'] ?> fade in" role="alert"><?= $value['message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<!-- Advanced login -->
<form method="POST" action="<?= URL::to('users/login_op'); ?>">
    <div class="panel panel-body login-form">
        <div class="text-center">
            <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
            <h5 class="content-group"><?php echo _("Ingresa a tu Cuenta"); ?> <small class="display-block"><?php echo _("Ingresa la informacion de la cuenta"); ?></small></h5>
        </div>

        <div class="form-group <?= (isset($errores['username'])) ? 'has-error' : '' ?> has-feedback has-feedback-left">
            <input type="text" name="username" placeholder="<?php echo _("Usuario"); ?>" class="form-control">
            <div class="form-control-feedback">
                <i class="icon-user text-muted"></i>
            </div>
        </div>

        <div class="form-group <?= (isset($errores['password'])) ? 'has-error' : '' ?> has-feedback has-feedback-left">
            <input type="password" name="password" placeholder="<?php echo _("Contrasena?"); ?>" class="form-control">
            <div class="form-control-feedback">
                <i class="icon-lock2 text-muted"></i>
            </div>
        </div>

        <div class="form-group login-options">
            <div class="row">
                <div class="col-sm-6">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="remember" class="styled" checked="checked">
                        <?php echo _("Guardar mi session"); ?>
                    </label>
                </div>

                <div class="col-sm-6 text-right">
                    <a href="<?= URL::to('home/forgot') ?>"><?php echo _("Olvido su Contrasena?"); ?></a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn bg-blue btn-block"><?php echo _("Ingresar"); ?> <i class="icon-arrow-right14 position-right"></i></button>
        </div>

        <input type="hidden" name="token_form" value="<?= Token::generate() ?>">
        <input type="hidden" name="process" value="login"/>

        <div class="content-divider text-muted form-group"><span><?php echo _("o registrate con:"); ?></span></div>
        <ul class="list-inline form-group list-inline-condensed text-center">
            <li><a href="login_advanced.html#" class="btn border-indigo text-indigo btn-flat btn-icon btn-rounded"><i class="icon-facebook"></i></a></li>
            <li><a href="login_advanced.html#" class="btn border-pink-300 text-pink-300 btn-flat btn-icon btn-rounded"><i class="icon-dribbble3"></i></a></li>
            <li><a href="login_advanced.html#" class="btn border-slate-600 text-slate-600 btn-flat btn-icon btn-rounded"><i class="icon-github"></i></a></li>
            <li><a href="login_advanced.html#" class="btn border-info text-info btn-flat btn-icon btn-rounded"><i class="icon-twitter"></i></a></li>
        </ul>

        <div class="content-divider text-muted form-group"><span><?php echo _("Crea una cuenta!"); ?></span></div>
        <a href="<?= URL::to('home/register') ?>" class="btn btn-default btn-block content-group"><?php echo _("Registrate"); ?></a>
        <span class="help-block text-center no-margin"><?php echo _("Si ingreso estoy confirmando que conosco"); ?> <a href="login_advanced.html#"><?php echo _("Terminos y condiciones"); ?></a> and <a href="login_advanced.html#"><?php echo _("y las Politicas de Cookies"); ?></a></span>
    </div>
</form>
<!-- /advanced login -->