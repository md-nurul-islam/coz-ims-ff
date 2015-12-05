<div class="col-lg-12">


    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'color-details-form',
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

    <?php if (Yii::app()->user->hasFlash('success')) { ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php } ?>

    <div class="box box-info">

        <div class="box-body">

            <div class="form-group">
                <div class="col-sm-10">
                    <label>Fields with <span class="required">*</span> are required.</label>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'name', array(
                        'size' => 60,
                        'maxlength' => 255,
                        'placeholder' => 'Color Name',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'name', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'hex_code', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'hex_code', array(
                        'rows' => 6,
                        'cols' => 45,
                        'placeholder' => 'Code',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'hex_code', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

        </div><!-- /.box-body -->

        <div class="box-footer">
            <?php echo CHtml::submitButton(($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit', 'class' => 'btn btn-info pull-right')); ?>
        </div><!-- /.box-footer -->

        <?php $this->endWidget(); ?>

    </div><!-- /.box -->

</div>