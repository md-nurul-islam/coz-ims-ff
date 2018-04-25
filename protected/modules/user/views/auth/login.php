<div class="wrapper login-box-body">
    <div class="container">

        <div class="login-logo">
            <a href="/site/login"><b>Ess</b>ey</a>
        </div><!-- /.login-logo -->

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array(
                'class' => 'form',
            ),
        ));
        ?>

        <?php if (Yii::app()->user->hasFlash('error')) { ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        <?php } ?>

        <?php echo $form->textField($model, 'username', array('placeholder' => 'Username')); ?>
        <?php echo $form->error($model, 'username'); ?>

        <?php echo $form->passwordField($model, 'hashed_password', array('placeholder' => 'Password')); ?>
        <?php echo $form->error($model, 'hashed_password'); ?>

        <?php echo $form->checkBox($model, 'rememberMe'); ?>
        <?php echo CHtml::submitButton('Sign In'); ?>
        <!--<button type="submit" id="login-button">Login</button>-->

        <?php $this->endWidget(); ?>
    </div>

    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>


<!--<div class="login-box-body">
    <p class="login-box-msg">Sign in</p>





    <div class="form-group has-feedback">
        
        <span class="glyphicon glyphicon-user form-control-feedback"></span>

    </div>

    <div class="form-group has-feedback">
        
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

    </div>

    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>

                    Remember Me
                </label>
            </div>
        </div> /.col 

        <div class="col-xs-4">
            
        </div> /.col 
    </div>-->



<!--
    <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
    </div> /.social-auth-links -->

<!--    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>-->

<!--</div> /.login-box-body -->
