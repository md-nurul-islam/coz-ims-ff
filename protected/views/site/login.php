
<div class="login-box-body">
    <p class="login-box-msg">Sign in</p>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>

    <div class="form-group has-feedback">
        <?php echo $form->textField($model, 'username', array('placeholder' => 'username', 'class' => 'form-control')); ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->passwordField($model, 'hashed_password', array('placeholder' => 'Password', 'class' => 'form-control')); ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <?php echo $form->error($model, 'hashed_password'); ?>
    </div>

    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                    <?php echo $form->checkBox($model, 'rememberMe'); ?>
                    Remember Me
                </label>
            </div>
        </div><!-- /.col -->

        <div class="col-xs-4">
            <?php echo CHtml::submitButton('Sign In', array('class' => 'btn btn-primary btn-block btn-flat')); ?>
        </div><!-- /.col -->
    </div>


    <?php $this->endWidget(); ?>
    <!--
        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div> /.social-auth-links -->

    <!--    <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>-->

</div><!-- /.login-box-body -->
