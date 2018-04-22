<div class="col-lg-12">

    <div class="box box-info">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'customer-details-form',
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

            <?php echo $form->errorSummary($model); ?>

            <div class="form-group">
                <div class="col-sm-10">
                    <label>Fields with <span class="required">*</span> are required.</label>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'customer_name', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'customer_name', array(
                        'size' => 60,
                        'maxlength' => 200,
                        'placeholder' => 'Customer name',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'customer_name', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'customer_address', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textArea($model, 'customer_address', array(
                        'size' => 60,
                        'rows' => 4,
                        'cols' => 45,
                        'maxlength' => 500,
                        'placeholder' => 'Customer Address',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'customer_address', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'customer_contact1', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'customer_contact1', array(
                        'size' => 60,
                        'maxlength' => 100,
                        'placeholder' => 'Customer Contact 1',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'customer_contact1', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'customer_contact2', array('class' => 'col-sm-2 control-label')); ?>
                <div class="col-sm-10">
                    <?php
                    echo $form->textField($model, 'customer_contact2', array(
                        'size' => 60,
                        'maxlength' => 100,
                        'placeholder' => 'Customer Contact 2',
                        'class' => 'form-control',
                    ));
                    ?>
                    <?php echo $form->error($model, 'customer_contact2', array('class' => 'alert alert-danger')); ?>
                </div>
            </div>

            <div class="box-footer">
                <?php echo CHtml::submitButton(($model->isNewRecord) ? 'Add' : 'Update', array('id' => 'btn-submit', 'class' => 'btn btn-success btn-flat pull-right')); ?>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>
</div><!-- form -->