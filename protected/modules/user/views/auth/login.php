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

<?php echo $form->checkBox($model, 'rememberMe'); ?> <label>Remember Me</label>
<?php echo CHtml::submitButton('Sign In' , array('class' => 'text-green')); ?>

<?php $this->endWidget(); ?>

<!--
    <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
    </div> /.social-auth-links -->

<!--    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>-->

<!--</div> /.login-box-body -->
