<div class="col-lg-12">

    <div class="box box-info">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'change-password-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => true,
            'htmlOptions' => array(
                'class' => 'form-horizontal',
            ),
        ));
        ?>

        <div class="box-body">

            <div class="form-group">
                <div class="col-sm-10">
                    <label>Fields with <span class="required">*</span> are required.</label>
                </div>
            </div>

            <?php if (!empty($model->errors)) { ?>
                <?php echo Settings::generatePrettyError($model->errors); ?>
            <?php } ?>

            <?php if (Yii::app()->user->hasFlash('success')) { ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php } ?>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'current_password', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->passwordField($model, 'current_password', array(
                        'size' => 60,
                        'maxlength' => 255,
                        'placeholder' => 'Current Password',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'current_password', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'new_password', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->passwordField($model, 'new_password', array(
                        'size' => 60,
                        'maxlength' => 255,
                        'placeholder' => 'New Password',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'current_password', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'repeat_password', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->passwordField($model, 'repeat_password', array(
                        'size' => 60,
                        'maxlength' => 255,
                        'placeholder' => 'Repeat Password',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'current_password', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>


        </div>

        <div class="box-footer">
            <?php echo CHtml::submitButton(($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit', 'class' => 'btn btn-info pull-right')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div>

</div>
<div class="clearfix"></div>