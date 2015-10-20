<!-- Registration form -->
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
<!-- Registration form -->
<form method="POST" action="<?= URL::to('users/register_op'); ?>"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel registration-form">
                <div class="panel-body">
                    <div class="text-center">
                        <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                        <h5 class="content-group-lg"><?php echo _("Crea tu Cuenta"); ?> <small class="display-block"><?php echo _("Todos los campos son obligatorios"); ?></small></h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" placeholder="<?php echo _("Su Nombre"); ?>" class="form-control">
                                <div class="form-control-feedback">
                                    <i class="icon-user-check text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input type="text" name="lastname" value="<?php echo escape(Input::get('lastname')); ?>" placeholder="<?php echo _("Sus Apellidos"); ?>" class="form-control">
                                <div class="form-control-feedback">
                                    <i class="icon-user-check text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="text" name="email" value="<?php echo escape(Input::get('email')); ?>" placeholder="<?php echo _("Sus Email"); ?>" class="form-control">
                        <div class="form-control-feedback">
                            <i class="icon-mail5 text-muted"></i>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" placeholder="<?php echo _("Su Usuario"); ?>" class="form-control">
                                <div class="form-control-feedback">
                                    <i class="icon-user-plus text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input type="password" name="password" placeholder="<?php echo _("Su Contrasena"); ?>" class="form-control">
                                <div class="form-control-feedback">
                                    <i class="icon-user-lock text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <input type="password" name="password_again" class="form-control" placeholder="<?php echo _("Repita la contrasena"); ?>">
                                <div class="form-control-feedback">
                                    <i class="icon-user-lock text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="styled" checked="checked">
                                <?php echo _("Recibir informacion"); ?>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="styled">
                                <?php echo _("Acepto los"); ?> <a href="<?= URL::to('home') ?>"><?php echo _("Terminos y Condiciones"); ?></a>
                            </label>
                        </div>
                    </div>

                    <div class="text-right">
                        <a class="btn btn-link" href="<?= URL::to('home/login') ?>"><i class="icon-arrow-left13 position-left"></i> <?php echo _("Regresar a login"); ?></a>                        
                        <button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-10"><b><i class="icon-plus3"></i></b> <?php echo _("Crear mi cuenta"); ?></button>
                    </div>
                    <input type="hidden" name="token_form" value="<?= Token::generate() ?>">
                    <input type="hidden" name="process" value="register"/>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- /registration form -->